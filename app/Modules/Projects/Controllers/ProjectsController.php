<?php

namespace App\Modules\Projects\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Projects\Models\MlstBmsbProjectStatus;
use App\Modules\Projects\Models\MlstBmsbProjectType;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectWebPage;
use App\Modules\Projects\Models\ProjectWing;
use App\Modules\Projects\Models\ProjectBlocks;
use App\Models\MlstBmsbAmenity;
use App\Models\MlstBmsbBlockType;
use App\Models\ProjectBlock;
use App\Models\ProjectStatus;
use App\Models\ProjectOtherBlock;
use Auth;
use Excel;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Classes\S3;

class ProjectsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("Projects::index");
    }

    public function manageProjects() {

        $getProjects = Project::select('id', 'created_by', 'project_status', 'project_type_id', 'project_name', 'created_at')->with(['getEmployee', 'projectTypes', 'projectStatus'])->get();
        $i = 0;
        foreach ($getProjects as $getProject) {
            $getProjects[$i]['projectStatus'] = $getProject['projectStatus']['project_status'];
            $getProjects[$i]['fullName'] = $getProject['getEmployee']['first_name'] . ' ' . $getProject['getEmployee']['last_name'];
            $getProjects[$i]['projectType'] = $getProject['projectTypes']['project_type'];
            $i++;
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($getProjects)) {
            $result = ['success' => true, 'records' => $getProjects, 'exportData' => $export];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function webpageDetails($id) {
        return view("Projects::webpagedetails")->with(["projectId" => $id]);
    }

    public function webpageSettings() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $msg = "";
        if (!empty($input["getDataByPrid"])) { //for list
            
            $getProjectDetails = ProjectWebPage::select("pr.project_name","project_id", "alias_status", "project_alias", "short_description", "brief_description", "project_country", "project_state", "project_city", "project_location", "project_address", "project_contact_numbers", "project_website", "page_title", "seo_url", "meta_description", "meta_keywords", "canonical_tag")
                    ->leftJoin('projects as pr','pr.id', '=', 'project_web_pages.project_id')
                    ->where("project_web_pages.project_id", "=", $input["getDataByPrid"])
                    ->get();

            unset($input["settingData"]["prid"], $input["settingData"]["csrfToken"]);
            if (!empty($input["settingData"]) && empty($getProjectDetails[0])) { //insert
                $input['settingData']['client_id'] = config('global.client_id');
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['settingData'] = array_merge($input['settingData'], $create);
                $actionProject = ProjectWebPage::create($input['settingData']);
                $msg = "Record added successfully";
            } else if (!empty($input["settingData"]) && !empty($getProjectDetails[0])) { //update
                $input['settingData']['client_id'] = config('global.client_id');
                $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                $input['settingData'] = array_merge($input['settingData'], $update);
                $actionProject = ProjectWebPage::where('project_id', $input["getDataByPrid"])->update($input['settingData']);
                $msg = "Record updated successfully";
            }
        }
        if (!empty($getProjectDetails[0])) {
            $result = ['success' => true, 'settingData' => $getProjectDetails[0], 'message' => $msg];
        } else {
            $result = ['success' => false, 'settingData' => [], 'message' => $msg];
        }
        return json_encode($result);
    }

    public function uploadsData(){

        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (empty($input))
            $input = Input::all();
        
        $projectId = $input["getDataByPrid"];
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $msg = "";

        $getProjectDetails = $getProjectStatusRecords = [];
        if(!empty($input["getDataByPrid"])){ //for list
            
            $getProjectDetails = ProjectWebPage::select("project_id","project_logo","project_thumbnail","project_favicon","project_banner_images","project_background_images","project_brochure",
                    "project_amenities_list","amenities_images","amenities_description","specification_images","specification_description","layout_plan_images","location_map_images","floor_plan_images",
                    "project_gallery","google_map_short_url","google_map_iframe","video_link","video_short_link")
                ->where("project_id", "=", $projectId)
                ->get();
            $getProjectStatusRecords = ProjectStatus::select('id', 'images', 'status', 'short_description')->where("project_id", "=", $projectId)->get();
            
            /*************getSpecifiction************* */
            $specificationTitle = array();
            if (!empty($getProjectDetails[0]->specification_images) && ($getProjectDetails[0]->specification_images !== 'null')) {
                $decodeSpecificationDetails = json_decode($getProjectDetails[0]->specification_images, true);
                foreach ($decodeSpecificationDetails as $key => $val) {
                    if (!empty($val['wing'])) {
                        $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                        $specificationTitle[$key] = ["image" => $val['specification_images'], "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $val['floors'])];
                    } else {
                        $specificationTitle[$key] = ["image" => $val['image'], "title" => $val['title']];
                    }
                }
            }
            $floorTitle = array();
            if (!empty($getProjectDetails[0]->floor_plan_images) && ($getProjectDetails[0]->floor_plan_images !== 'null')) {
                $decodeFloorDetails = json_decode($getProjectDetails[0]->floor_plan_images, true);
                foreach ($decodeFloorDetails as $key => $val) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                    $floorTitle[$key] = ["image" => $val['floor_plan_images'], "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $val['floors'])];
                }
            }
            $layoutTitle = array();
            if (!empty($getProjectDetails[0]->layout_plan_images) && $getProjectDetails[0]->layout_plan_images != "null") {
                $decodeLayoutDetails = json_decode($getProjectDetails[0]->layout_plan_images, true);
                foreach ($decodeLayoutDetails as $key => $val) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                    $layoutTitle[$key] = ["image" => $val['layout_plan_images'], "title" => $projectWingName[0]->wing_name];
                }
            }
            /*************getSpecifiction**************/
                      
            if (!empty($input['projectImages'])) {
                unset($input["projectImages"]["prid"],$input["projectImages"]["csrfToken"]);
                if (count($input['projectImages']) > 1) {
                    unset($input['projectImages']['upload']); 
                   
                    foreach ($input['projectImages'] as $key => $value) {
                        $isMultipleArr = is_array($input['projectImages'][$key]);
                        if ($isMultipleArr) {
                            $originalName = $input['projectImages'][$key][0]->getClientOriginalName();
                        } else {
                            $originalName = $input['projectImages'][$key]->getClientOriginalName();
                        }           
                        
                        if ($originalName !== 'fileNotSelected') {
                            $imgRules = array(
                                'project_logo' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_thumbnail' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_favicon' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_banner_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_background_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_brochure.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx',
                                'location_map_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'layout_plan_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                            );
                            $validator = Validator::make($input['projectImages'], $imgRules);

                            if ($validator->fails()) {
                                $result = ['success' => false, 'message' => $validator->messages()];
                                return json_encode($result);
                            } else {
                                $s3FolderName = '/project/' . $key;
                                $prImageName = array();
                                if ($isMultipleArr) {
                                    $prImageName = explode(",", $getProjectDetails[0][$key]);
                                    for ($i = 0; $i < count($input['projectImages'][$key]); $i++) {
                                        $imageName = 'project_' . $projectId . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key][$i]->getClientOriginalExtension();
                                        S3::s3FileUpload($input['projectImages'][$key][$i]->getPathName(), $imageName, $s3FolderName);
                                        $prImageName[] = $imageName;
                                    }
                                } else {
                                    $imageName = 'project_' . $projectId . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key]->getClientOriginalExtension();
                                    S3::s3FileUpload($input['projectImages'][$key]->getPathName(), $imageName, $s3FolderName);
                                    $prImageName[] = $imageName;
                                }
                            
                                $implodeImgName = implode(",",array_filter($prImageName,function($var){
                                if($var !== 'null' && $var !== '')
                                    return $var;
                                }));
                               
                                if (isset($input['statusData'])) {
                                    $input['statusData'][$key] = $implodeImgName;
                                } elseif (isset($input['specificationData']) || isset($input['floorData'])) {
                                    $objName = $input['objName'];
                                    $input[$objName][$key] = $implodeImgName;
                                } elseif (isset($input['layoutData'])) {
                                    $input['layoutData'][$key] = $implodeImgName;
                                } else {
                                    $input['projectData'][$key] = $implodeImgName;
                                }
                            }
                        }                          
                    }
                }
                else{
                    $actionProject = 1;
                    $msg = "Record updated successfully";
                }
            }

            if (!empty($input['projectData'])) {
                unset($input["projectData"]["csrfToken"]);
                if (!empty($input['projectData']['project_amenities_list'])) {
                    $input['projectData']['project_amenities_list'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $input['projectData']['project_amenities_list']));
                }
                $input['projectData']['project_id'] = $projectId;
                if (empty($getProjectDetails[0])) {
                    $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'], $create);
                    $actionProject = ProjectWebPage::create($input['projectData']);
                    $msg = "Record added successfully";
                } else {
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'], $update);
                    $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['projectData']);
                    $msg = "Record updated successfully";
                }
            }
            if (isset($input['statusData'])) {
                $input['statusData']['project_id'] = $projectId;
                $input['statusData']['short_description'] = !empty($input['statusData']['status_short_description']) ? $input['statusData']['status_short_description'] : "";
                $input['statusData']['client_id'] = config('global.client_id');
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['statusData'] = array_merge($input['statusData'], $create);
                ProjectStatus::create($input['statusData']);
                $msg = "Record added successfully";
                $getProjectStatusRecords = ProjectStatus::select('id', 'images', 'status', 'short_description')->get();
                $result = ['success' => true, 'message' => $msg, 'records' => $getProjectStatusRecords];
                return json_encode($result);
            }
            if (isset($input['specificationData']) || isset($input['floorData'])) {
                $objName = $input['objName'];
                $result = [];
                if (!empty($input[$objName]['modalData']['floors'])) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $input[$objName]['modalData']['wing'])->get();
                    $floorArr = array();
                    foreach ($input[$objName]['modalData']['floors'] as $key => $floor) {
                        unset($floor['$hashKey'], $floor['wingId']);
                        $floorId[] = $floor['id'];
                        $floorArr[] = $floor;
                    }
                    sort($floorId);
                    $input[$objName]['modalData']['floors'] = $floorId;

                    if (isset($input['specificationData'])) {
                        $input[$objName]['modalData']['specification_images'] = $implodeImgName;
                        if (!empty($getProjectDetails[0]->specification_images)) {
                            $mergeOldValue = json_decode($getProjectDetails[0]->specification_images, true);
                        }
                        $mergeOldValue[] = $input[$objName]['modalData'];
                        $input[$objName]['specification_images'] = json_encode($mergeOldValue);
                        $specificationTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $floorId)];
                    } else if (isset($input['floorData'])) {
                        $input[$objName]['modalData']['floor_plan_images'] = $implodeImgName;
                        if (!empty($getProjectDetails[0]->floor_plan_images)) {
                            $mergeOldValue = json_decode($getProjectDetails[0]->floor_plan_images, true);
                        }
                        $mergeOldValue[] = $input[$objName]['modalData'];
                        $input[$objName]['floor_plan_images'] = json_encode($mergeOldValue);
                        $specificationTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $floorId)];
                    }
                    unset($input[$objName]['modalData']);
                    if (empty($getProjectDetails[0])) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input[$objName] = array_merge($input[$objName], $create);
                        $actionProject = ProjectWebPage::create($input[$objName]);
                        $msg = "Record added successfully";

                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    } else {
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input[$objName] = array_merge($input[$objName], $update);
                        $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input[$objName]);

                        $msg = "Record updated successfully";
                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    }
                }
            }
            if (isset($input['layoutData'])) {
                $result = [];
                if (!empty($input['layoutData']['modalData'])) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $input['layoutData']['modalData']['wing'])->get();

                    $input['layoutData']['modalData']['layout_plan_images'] = $implodeImgName;
                    if (!empty($getProjectDetails[0]->layout_plan_images)) {
                        $mergeOldValue = json_decode($getProjectDetails[0]->layout_plan_images, true);
                    }
                    $mergeOldValue[] = $input['layoutData']['modalData'];
                    $input['layoutData']['layout_plan_images'] = json_encode($mergeOldValue);
           
                    $layoutTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name];
                    unset($input['layoutData']['modalData']);
                    if (empty($getProjectDetails)) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input['layoutData'] = array_merge($input['layoutData'], $create);
                        $actionProject = ProjectWebPage::create($input['layoutData']);
                        $msg = "Record added successfully";

                        $result = ['success' => true, 'message' => $msg, 'layoutTitle' => $layoutTitle];
                        return json_encode($result);
                    } else {
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input['layoutData'] = array_merge($input['layoutData'], $update);
                        $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['layoutData']);
                        $msg = "Record updated successfully";
                        $result = ['success' => true, 'message' => $msg, 'layoutTitle' => $layoutTitle];
                        return json_encode($result);
                    }
                    
                }
            }

            if (!empty($getProjectDetails[0])) {
                $result = ['success' => true, 'uploadData' => $getProjectDetails[0], "getProjectStatusRecords" => $getProjectStatusRecords, 'specificationTitle' => $specificationTitle, 'floorTitle' => $floorTitle, 'layoutTitle' => $layoutTitle, 'message' => $msg];
            } else {
                $result = ['success' => false, 'settingData' => [], 'message' => $msg];
            }
            return json_encode($result);
        }
    }
    
    public function getInventoryDetails() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $projectId = $input['data']['getDataByPrid'];
        $msg = "";
//        print_r($input);
        if(!empty($input['data']["getDataByPrid"])){            
            if ($input['data']['wingId'] == 0) {
                $projectWing = ProjectWing::select('id', 'project_id', 'wing_name', 'number_of_floors')->where('project_id', $projectId)->orderBy('id', 'ASC')->first();
                $projectData = ProjectBlock::select('project_blocks.id', 'project_id','block_type_id','wing_id','block_sub_type','block_sub_type_label','block_availablity',
                        'sellable_area_in_sqft','sellable_area_in_sqmtr','block_quantity','block_description','project_blocks.show_on_website',
                        'ob.id as other_block_id', 'ob.other_label', 'ob.area_in_sqft', 'ob.area_in_sqmtr', 'ob.other_block_show_on_website','bt.block_name')
                        ->leftJoin('project_other_blocks as ob', 'ob.block_id','=','project_blocks.id')
                        ->leftJoin('laravel_developement_master_edynamics.mlst_bmsb_block_types as bt', 'bt.id','=','project_blocks.block_type_id')
                        ->where([['wing_id', '=', $projectWing->id], ['project_id', '=', $projectId]])->orderBy('wing_id', 'ASC')
                        ->get();
            } else {
                $projectData = ProjectBlock::select('project_blocks.id', 'project_id','block_type_id','wing_id','block_sub_type','block_sub_type_label','block_availablity',
                        'sellable_area_in_sqft','sellable_area_in_sqmtr','block_quantity','block_description','project_blocks.show_on_website',
                        'ob.id as other_block_id', 'ob.other_label', 'ob.area_in_sqft', 'ob.area_in_sqmtr', 'ob.other_block_show_on_website','bt.block_name')
                        ->leftJoin('project_other_blocks as ob', 'ob.block_id','=','project_blocks.id')
                        ->leftJoin('laravel_developement_master_edynamics.mlst_bmsb_block_types as bt', 'bt.id','=','project_blocks.block_type_id')
                        ->where([['wing_id', '=', $input['data']['wingId']], ['project_id', '=', $projectId]])->get();
            }
            if(!empty($input['data']['inventoryData'])){
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $input['data']['inventoryData']['project_id'] = $projectId;
                $input['data']['inventoryData']['wing_id'] = $input['data']['wingId'];
                //$isBlockExist = ProjectBlock::where(['id' => $input['data']['inventoryData']['id'],'project_id' => $projectId, 'wing_id' => $input['data']['wingId']])->first();
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                if (empty($input['data']['inventoryData']['id'])) {
                    $input['data']['inventoryData']['client_id'] = config('global.client_id');
                    $input['inventoryData'] = array_merge($input['data']['inventoryData'], $create);
                    $actionProject = ProjectBlock::create($input['data']['inventoryData']);  
                    if(!empty($input['data']['otherData'])){
                        foreach($input['data']['otherData'] as $record){
                            if(!empty($record['other_label'])){
                                $record['block_id'] = $actionProject->id;
                                $otherData = ProjectOtherBlock::create($record);
                            }
                        }
                    }                   
                    $msg = "Record added successfully";
                } else {
                    
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['data']['inventoryData'] = array_merge($input['data']['inventoryData'], $update);
                    unset($input['data']['inventoryData']['block_name'],$input['data']['inventoryData']['other_block_id'],$input['data']['inventoryData']['other_label'],
                            $input['data']['inventoryData']['area_in_sqft'],$input['data']['inventoryData']['area_in_sqmtr'],$input['data']['inventoryData']['other_block_show_on_website']);
                    $actionProject = ProjectBlock::where(['id' => $input['data']['inventoryData']['id'], 'project_id' => $projectId, 'wing_id' => $input['data']['wingId']])
                            ->update($input['data']['inventoryData']);
                    
                    if(!empty($input['data']['otherData'])){
                        foreach($input['data']['otherData'] as $record){
                            if(!empty($record['other_label'])){
                                if(!empty($record['other_block_id'])){     
                                    $pkid = $record['other_block_id'];
                                    unset($record['other_block_id']);
                                    $record = array_merge($record, $update);
                                    $otherData = ProjectOtherBlock::where(['id' => $pkid])->update($record);
                                }else{
                                    $record["block_id"] = $input['data']['inventoryData']['id'];
                                    $record = array_merge($record, $create);
                                    $otherData = ProjectOtherBlock::create($record);
                                }
                            }
                        }
                    }
                    $msg = "Record updated successfully";
                }
            }
        } 
        if (!empty($projectData)) {
            $result = ['success' => true, 'records' => $projectData, 'message' => $msg];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
            
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
//        $userPermission = json_decode(Auth()->guard('admin')->user()->employee_submenus, true);
//        if (in_array('050102', $userPermission)) {
            return view("Projects::create");
//        }else{
//            return view("layouts.backend.error401");
//        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input = array_merge($input['data'], $create);
        $createProject = Project::create($input);
        if (!empty($createProject)) {
            $result = ['success' => true, 'message' => 'Employee registeration successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
            return json_encode($result);
        }
    }

    public function getprojects() {
        $getProjects = Project::with(['getEmployee', 'projectTypes', 'projectStatus'])->get();
        if (!empty($getProjects)) {
            $result = ['success' => true, 'records' => $getProjects];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getProjectWings() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $result = ProjectWing::where('project_id', '=', $input['project_id'])->get();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['result' => "No wings found", 'status' => true]);
        }
    }

    public function getFloorDetails() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $result = ProjectBlocks::where('project_id', '=', $input['project_id'])->get();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['result' => "No wings found", 'status' => true]);
        }
    }

    public function getAmenitiesListOnEdit() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $amenityId = $request['data'];
        $arr = explode(",", $amenityId);
        $getAmenityList = MlstBmsbAmenity::select('id', 'name_of_amenity')->whereIn('id', $arr)->get();
        if (!empty($getAmenityList)) {
            $result = ['success' => true, 'records' => $getAmenityList];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
        return json_encode($result);
    }



    public function getBlocks() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $projectId = $request['data']['projectId'];
//        $getBlockList = ProjectBlock::with('getBlockType')->where("project_id", $projectId)->get();
        $getBlockList = MlstBmsbBlockType::select('id','project_type_id','block_name')->get();
        //print_r($getBlockList);exit;
        if (!empty($getBlockList)) {
            $result = ['success' => true, 'records' => $getBlockList];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
        return json_encode($result);
    }

    public function deleteStatus() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $statusId = $request['data']['statusId'];
        if (!empty($request['data']['selectedImages'])) {
            foreach ($request['data']['selectedImages'] as $key => $value) {
                $path = "/project/images/" . $value;
                S3::s3FileDelete($path);
            }
        }
        ProjectStatus::where('id', $statusId)->delete();
        $msg = "Record has been deleted successfully";
        $getProjectStatusRecords = ProjectStatus::select('id', 'images', 'status', 'short_description')->get();
        $result = ['success' => true, 'message' => $msg, 'records' => $getProjectStatusRecords];
        return json_encode($result);
    }

    public function deleteImage() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if ($request['tblFieldName'] == "specification_images" || $request['tblFieldName'] == "layout_plan_images" || $request['tblFieldName'] == "floor_plan_images") {
          
            $selectedImgs = json_encode($request['selectedImg']);
            $path = $request['folderName'] . $request['delImgName'];
            $deleteImg = S3::s3FileDelete($path);
        } else {
            $selectedImgs = implode(',', $request['selectedImg']);
            $path = $request['folderName'] . $request['delImgName'];
            $deleteImg = S3::s3FileDelete($path);
        }
        if ($deleteImg) {
            ProjectWebPage::where('id', $request['tblRowId'])->update([$request['tblFieldName'] => $selectedImgs]);
            $result = ['success' => true, 'message' => "Image deleted successfully"];
        } else {
            $result = ['success' => false, 'message' => "Something went wrong. Please check internet connection"];
        }
        return json_encode($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function projectType() {
        $typeList = MlstBmsbProjectType::all();
        if (!empty($typeList)) {
            $result = ['success' => true, 'records' => $typeList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function projectStatus() {
        $typeStatus = MlstBmsbProjectStatus::all();
        if (!empty($typeStatus)) {
            $result = ['success' => true, 'records' => $typeStatus];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getWings() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $projectId = $request['data']['projectId'];
        $projectWing = ProjectWing::select('id', 'project_id', 'wing_name', 'number_of_floors')->where('project_id', $projectId)->get();
        if (!empty($projectWing)) {
            $result = ['success' => true, 'records' => $projectWing];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function manageProjectsExportToExcel() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);

        $getProjectData = array();
        if (in_array('01401', $array)) {
            $getProjects = Project::select('id', 'created_by', 'project_status', 'project_type_id', 'project_name', 'created_at')->with(['getEmployee', 'projectTypes', 'projectStatus'])->get();
            $getCount = Project::select('id', 'created_by', 'project_status', 'project_type_id', 'project_name', 'created_at')->with(['getEmployee', 'projectTypes', 'projectStatus'])->get()->count();
            $j = 1;
            for ($i = 0; $i < count($getProjects); $i++) {
                $getProject['Sr No.'] = $j++;
                $getProject['Registration Date & Time'] = $getProjects[$i]['created_at'];
                $getProject['Registered by'] = $getProjects[$i]['getEmployee']['first_name'] . ' ' . $getProjects[$i]['getEmployee']['last_name'];
                $getProject['Project Name'] = $getProjects[$i]['project_name'];
                $getProject['Project Type'] = $getProjects[$i]['projectTypes']['project_type'];
                $getProject['Project Status'] = $getProjects[$i]['projectStatus']['project_status'];
                $getProjectData[] = $getProject;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Project Details', function($excel) use($getProjectData) {
                    $excel->sheet('sheet1', function($sheet) use($getProjectData) {
                        $sheet->fromArray($getProjectData);
                    });
                })->download('csv');
            }
        }
    }

}



 /*public function basicInfo() {
        try {
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);
            if (empty($input))
                $input = Input::all();

            $projectId = $input['project_id'];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=', $projectId)->first();

            if (!empty($input['projectImages'])) {
                if (count($input['projectImages']) > 1) {
                    unset($input['projectImages']['upload']);
                    foreach ($input['projectImages'] as $key => $value) {
                        $isMultipleArr = is_array($input['projectImages'][$key]);
                        if ($isMultipleArr) {
                            $originalName = $input['projectImages'][$key][0]->getClientOriginalName();
                        } else {
                            $originalName = $input['projectImages'][$key]->getClientOriginalName();
                        }
                        if ($originalName !== 'fileNotSelected') {
                            $imgRules = array(
                                'project_logo' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_thumbnail' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_favicon' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_banner_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_background_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_brochure.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx',
                                'location_map_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'layout_plan_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                            );
                            $validator = Validator::make($input['projectImages'], $imgRules);

                            if ($validator->fails()) {
                                $result = ['success' => false, 'message' => $validator->messages()];
                                return json_encode($result);
                            } else {
                                $s3FolderName = '/project/' . $key;
                                $prImageName = array();
                                if ($isMultipleArr) {
                                    $prImageName = explode(",", $isProjectExist[$key]);
                                    for ($i = 0; $i < count($input['projectImages'][$key]); $i++) {
                                        $imageName = 'project_' . $projectId . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key][$i]->getClientOriginalExtension();
                                        S3::s3FileUpload($input['projectImages'][$key][$i]->getPathName(), $imageName, $s3FolderName);
                                        $prImageName[] = $imageName;
                                    }
                                } else {
                                    
                                    if (!empty($input['projectImages'][$key])) {
                                        if ($isProjectExist[$key] !== $input['projectImages'][$key]) {
                                            $path = $s3FolderName . $isProjectExist[$key];
                                            S3::s3FileDelete($path);
                                        }
                                    }
                                    $imageName = 'project_' . $projectId . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key]->getClientOriginalExtension();
                                    S3::s3FileUpload($input['projectImages'][$key]->getPathName(), $imageName, $s3FolderName);
                                    $prImageName[] = $imageName;
                                }
                                $prImageName = array_filter($prImageName);
                                $implodeImgName = implode(",", $prImageName);
                                if (isset($input['statusData'])) {
                                    $input['statusData'][$key] = $implodeImgName;
                                } elseif (isset($input['specificationData']) || isset($input['floorData'])) {
                                    $objName = $input['objName'];
                                    $input[$objName][$key] = $implodeImgName;
                                } elseif (isset($input['layoutData'])) {
                                    $input['layoutData'][$key] = $implodeImgName;
                                } else {
                                    $input['projectData'][$key] = $implodeImgName;
                                }
                            }
                        }
                    }
                } else {
                    $actionProject = 1;
                    $msg = "Record updated successfully";
                }
            }

            if (isset($input['projectData'])) {
                if (!empty($input['projectData']['project_amenities_list'])) {
//                    $input['projectData']['project_amenities_list'] = $input['projectData']['project_amenities_list'];
//                } else {
                    $input['projectData']['project_amenities_list'] = implode(',', array_map(function($el) {
                                return $el['id'];
                            }, $input['projectData']['project_amenities_list']));
                }
                $input['projectData']['project_id'] = $projectId;
                if (empty($isProjectExist)) {
                    $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'], $create);
                    $actionProject = ProjectWebPage::create($input['projectData']);
                    $msg = "Record added successfully";
                } else {
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'], $update);

                    $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['projectData']);
                    $msg = "Record updated successfully";
                }
            }
            if (isset($input['inventoryData'])) {
                $input['inventoryData']['project_id'] = $projectId;
                $isBlockExist = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['inventoryData']['wing_id']])->first();
                if (empty($isBlockExist)) {
                    $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $input['inventoryData'] = array_merge($input['inventoryData'], $create);
                    $actionProject = ProjectBlock::create($input['inventoryData']);
                    $msg = "Record added successfully";
                } else {
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['inventoryData'] = array_merge($input['inventoryData'], $update);
                    $actionProject = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['inventoryData']['wing_id']])->update($input['inventoryData']);
                    $msg = "Record updated successfully";
                }
            }
            if (isset($input['statusData'])) {
                $input['statusData']['project_id'] = $projectId;
                $input['statusData']['short_description'] = !empty($input['statusData']['status_short_description']) ? $input['statusData']['status_short_description'] : "";

                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['statusData'] = array_merge($input['statusData'], $create);
                $actionProjectStatus = ProjectStatus::create($input['statusData']);
                $msg = "Record added successfully";
                $getProjectStatusRecords = ProjectStatus::select('id', 'images', 'status', 'short_description')->get();
                $result = ['success' => true, 'message' => $msg, 'records' => $getProjectStatusRecords];
                return json_encode($result);
            }
            if (isset($input['specificationData']) || isset($input['floorData'])) {
                $objName = $input['objName'];
                $result = [];
                if (!empty($input[$objName]['modalData']['floors'])) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $input[$objName]['modalData']['wing'])->get();
                    $floorArr = array();
                    foreach ($input[$objName]['modalData']['floors'] as $key => $floor) {
                        unset($floor['$hashKey'], $floor['wingId']);
                        $floorId[] = $floor['id'];
                        $floorArr[] = $floor;
                    }
                    sort($floorId);
                    $input[$objName]['modalData']['floors'] = $floorId;

                    if (isset($input['specificationData'])) {
                        $input[$objName]['modalData']['specification_images'] = $implodeImgName;
                        if (!empty($isProjectExist->specification_images)) {
                            $mergeOldValue = json_decode($isProjectExist->specification_images, true);
                        }
                        $mergeOldValue[] = $input[$objName]['modalData'];
                        $input[$objName]['specification_images'] = json_encode($mergeOldValue);
                        $specificationTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $floorId)];
                    } else if (isset($input['floorData'])) {
                        $input[$objName]['modalData']['floor_plan_images'] = $implodeImgName;
                        if (!empty($isProjectExist->floor_plan_images)) {
                            $mergeOldValue = json_decode($isProjectExist->floor_plan_images, true);
                        }
                        $mergeOldValue[] = $input[$objName]['modalData'];
                        $input[$objName]['floor_plan_images'] = json_encode($mergeOldValue);
                        $specificationTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $floorId)];
                    }
                    unset($input[$objName]['modalData']);
                    if (empty($isProjectExist)) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input[$objName] = array_merge($input[$objName], $create);
                        $actionProject = ProjectWebPage::create($input[$objName]);
                        $msg = "Record added successfully";

                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    } else {
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input[$objName] = array_merge($input[$objName], $update);
                        $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input[$objName]);

                        $msg = "Record updated successfully";
                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    }
                }
            }
            if (isset($input['layoutData'])) {
                $result = [];
                if (!empty($input['layoutData']['modalData'])) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $input['layoutData']['modalData']['wing'])->get();

                    if (isset($input['layoutData'])) {
                        $input['layoutData']['modalData']['layout_plan_images'] = $implodeImgName;
                        if (!empty($isProjectExist->layout_plan_images)) {
                            $mergeOldValue = json_decode($isProjectExist->layout_plan_images, true);
                        }
                        $mergeOldValue[] = $input['layoutData']['modalData'];
                        $input['layoutData']['layout_plan_images'] = json_encode($mergeOldValue);
                        $layoutTitle = ["image" => $implodeImgName, "title" => $projectWingName[0]->wing_name];
                    }
                    unset($input['layoutData']['modalData']);
                    if (empty($isProjectExist)) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input['layoutData'] = array_merge($input['layoutData'], $create);
                        $actionProject = ProjectWebPage::create($input['layoutData']);
                        $msg = "Record added successfully";

                        $result = ['success' => true, 'message' => $msg, 'layoutTitle' => $layoutTitle];
                        return json_encode($result);
                    } else {
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input['layoutData'] = array_merge($input['layoutData'], $update);
                        $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['layoutData']);

                        $msg = "Record updated successfully";
                        $result = ['success' => true, 'message' => $msg, 'layoutTitle' => $layoutTitle];
                        return json_encode($result);
                    }
                }
            }
            if (!empty($actionProject)) {
                $result = ['success' => true, 'message' => $msg];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong.'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    public function getProjectDetails($id) {
        $getProjectDetails = $getProjectStatusRecords = $getProjectInventory = array();
        $getProjectDetails = ProjectWebPage::where("project_id", "=", $id)->get();
        $getProjectStatusRecords = ProjectStatus::select('id', 'images', 'status', 'short_description')->where("project_id", "=", $id)->get();

        $getWing = ProjectWing::select('id', 'project_id', 'wing_name', 'number_of_floors')->where('project_id', $id)->orderBy('id', 'ASC')->first();
        if (!empty($getWing)) {
            $getProjectInventory = ProjectBlock::where([['wing_id', '=', $getWing->id], ['project_id', '=', $id]])->orderBy('wing_id', 'ASC')->get();
        } else {
            $getProjectInventory = ProjectBlock::where([['project_id', '=', $id]])->orderBy('wing_id', 'ASC')->get();
        }
        
        $specificationTitle = array();
        if (!empty($getProjectDetails[0]->specification_images) && ($getProjectDetails[0]->specification_images !== 'null')) {
            $decodeSpecificationDetails = json_decode($getProjectDetails[0]->specification_images, true);
            foreach ($decodeSpecificationDetails as $key => $val) {
                if (!empty($val['wing'])) {
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                    $specificationTitle[$key] = ["image" => $val['specification_images'], "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $val['floors'])];
                } else {
                    $specificationTitle[$key] = ["image" => $val['image'], "title" => $val['title']];
                }
            }
        }
        $floorTitle = array();
        if (!empty($getProjectDetails[0]->floor_plan_images) && ($getProjectDetails[0]->floor_plan_images !== 'null')) {
            $decodeFloorDetails = json_decode($getProjectDetails[0]->floor_plan_images, true);
            foreach ($decodeFloorDetails as $key => $val) {
                $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                $floorTitle[$key] = ["image" => $val['floor_plan_images'], "title" => $projectWingName[0]->wing_name . ", Floor:" . implode(",", $val['floors'])];
            }
        }
        $layoutTitle = array();
        if (!empty($getProjectDetails[0]->layout_plan_images) && $getProjectDetails[0]->layout_plan_images != "null") {
            $decodeLayoutDetails = json_decode($getProjectDetails[0]->layout_plan_images, true);
            foreach ($decodeLayoutDetails as $key => $val) {
                $projectWingName = ProjectWing::select('wing_name')->where('id', $val['wing'])->get();
                $layoutTitle[$key] = ["image" => $val['layout_plan_images'], "title" => $projectWingName[0]->wing_name];
            }
        }
       
        if (!empty($getProjectDetails[0])) {
            $result = ['success' => true, 'details' => $getProjectDetails[0], 'projectStatusRecords' => $getProjectStatusRecords, 'specificationTitle' => $specificationTitle, 'floorTitle' => $floorTitle, 'layoutTitle' => $layoutTitle, 'getProjectInventory' => $getProjectInventory];
        } else {
            $result = ['success' => false, 'details' => array(), 'projectStatusRecords' => array(), 'specificationTitle' => array(), 'floorTitle' => array(), 'layoutTitle' => array(), 'getProjectInventory' => array()];
        }
        return json_encode($result);
    }*/