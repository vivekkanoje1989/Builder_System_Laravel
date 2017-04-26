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
use App\Models\MlstBmsbAmenity;
use App\Models\MlstBmsbBlockType;
use App\Models\ProjectBlock;
use App\Models\ProjectStatus;
use Auth;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("Projects::create");
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
        $input = array_merge($input['data'],$create);   
        $createProject = Project::create($input);
        if(!empty($createProject)){
            $result = ['success' => true, 'message' => 'Employee registeration successfully'];
            echo json_encode($result);
        }else{
            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
            echo json_encode($result);
        }
    }
    
    /*public function basicInfo(){
        try{
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=',$input['projectId'])->first();
            if (empty($isProjectExist)) {
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['projectData'] = array_merge($input['projectData'],$create);
                $input['projectData']['project_id'] = $input['projectId'];
                $actionProject = ProjectWebPage::create($input['projectData']);
                $msg = "Record added successfully";
            }
            if(!empty($actionProject)){
                $result = ['success' => true, 'message' => $msg];
            }else{
                $result = ['success' => false, 'message' => 'Something went wrong.'];
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }*/
        
    public function basicInfo(){
        try{
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);  
            if(empty($input))
                $input = Input::all();
            //echo "<pre>";print_r($input);exit;
            $projectId = $input['project_id'];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=',$projectId)->first();
            
            if(!empty($input['projectImages'])){
                if(count($input['projectImages']) > 1){
                    unset($input['projectImages']['upload']);
                    foreach($input['projectImages'] as $key => $value){                            
                        $originalName = $input['projectImages'][$key][0]->getClientOriginalName();
                        if ($originalName !== 'fileNotSelected') {
                            $imgRules = array(
                                'project_logo' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_thumbnail' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_favicon' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_banner_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_background_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'project_broacher.*' => 'mimes:jpeg,png,jpg,gif,svg',
                                'location_map_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                            );
                            $validator = Validator::make($input['projectImages'], $imgRules);

                            if ($validator->fails()) {
                                $result = ['success' => false, 'message' => $validator->messages()];
                                return json_encode($result);
                            } else {
                                //find images name depending on $input['projectImages'][$key]
                                for($i=0; $i < count($input['projectImages'][$key]); $i++){
                                    //upload image
                                    if(isset($input['statusData'])){
                                        $input['statusData'][$key] = "aa";
                                    }else{
                                         $input['projectData'][$key] = "aa";
                                    }
                                }
                            }
                        }
                    } 
                }
            }
            
            if(isset($input['projectData'])){
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
                    $input['projectData'] = array_merge($input['projectData'],$create);                
                    $actionProject = ProjectWebPage::create($input['projectData']);
                    $msg = "Record added successfully";
                }else{
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'],$update);
                    $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['projectData']);
                    $msg = "Record updated successfully";
                }
            }
            if(isset($input['inventoryData'])){
                $input['inventoryData']['project_id'] = $projectId;
                $isBlockExist = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['inventoryData']['wing_id']])->first();
                if (empty($isBlockExist)) {
                    $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $input['inventoryData'] = array_merge($input['inventoryData'],$create);                
                    $actionProject = ProjectBlock::create($input['inventoryData']);
                    $msg = "Record added successfully";
                }else{
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['inventoryData'] = array_merge($input['inventoryData'],$update);
                    $actionProject = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['inventoryData']['wing_id']])->update($input['inventoryData']);
                    $msg = "Record updated successfully";
                }
            }    
            if(isset($input['statusData'])){
                $input['statusData']['project_id'] = $projectId;
                $input['statusData']['short_description'] = !empty($input['statusData']['status_short_description']) ? $input['statusData']['status_short_description'] : "";
                //$isBlockExist = ProjectStatus::where(['project_id' => $projectId, 'wing_id' => $input['inventoryData']['wing_id']])->first();
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['statusData'] = array_merge($input['statusData'],$create);                
                $actionProjectStatus = ProjectStatus::create($input['statusData']);
                $msg = "Record added successfully";
                $getProjectStatusRecords = ProjectStatus::select('images', 'status', 'short_description')->get();
                $result = ['success' => true, 'message' => $msg, 'records' => $getProjectStatusRecords];
                return json_encode($result);
            }
            if(!empty($actionProject)){
                $result = ['success' => true, 'message' => $msg];
            }else{
                $result = ['success' => false, 'message' => 'Something went wrong.'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    public function showProjectDetails() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $getProjectDetails = ProjectWebPage::where("project_id","=",$input['data']['projectId'])->get();
        $getProjectStatusRecords = ProjectStatus::select('images', 'status', 'short_description')->get();
        if(!empty($getProjectDetails[0])){
//            $arr = explode(",", $getProjectDetails[0]['project_amenities_list']);
//            $getAmenities = MlstBmsbAmenity::select('id','name_of_amenity')->whereIn('id', $arr)->get();
//            $getProjectDetails[0]['project_amenities_list'] = json_encode($getAmenities);

            $result = ['success' => true, 'details' => $getProjectDetails[0], 'projectStatusRecords' => $getProjectStatusRecords];
        }else{
            $result = ['success' => false, 'message' => 'Record not exist.'];
        }
        echo json_encode($result);
    }

    public function getAmenitiesListOnEdit() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $amenityId = $request['data'];
        $arr = explode(",", $amenityId);
        $getAmenityList = MlstBmsbAmenity::select('id','name_of_amenity')->whereIn('id', $arr)->get();
        if (!empty($getAmenityList)) {
            $result = ['success' => true, 'records' => $getAmenityList];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
        return json_encode($result);
    }
    
    public function getBlocks() {
        $getBlockList = MlstBmsbBlockType::select('id','block_name')->get();
        if (!empty($getBlockList)) {
            $result = ['success' => true, 'records' => $getBlockList];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
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
    public function webPage() {
        return view("Projects::webpage");
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
    public function getWings(){
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

}
