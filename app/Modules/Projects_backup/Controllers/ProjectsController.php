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

//    public function getProjectInfo() {
//        $postdata = file_get_contents("php://input");
//        $input = json_decode($postdata, true);
//        $allProjectDetails = ProjectWebPage::where('id',$input['id'])->get();
//        //print_r($allProjectDetails);exit;
//        if (!empty($allProjectDetails)) {
//            $result = ['success' => true, 'records' => $allProjectDetails];
//            echo json_encode($result);
//        } else {
//            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
//            echo json_encode($result);
//        }
//    }

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

        $input = array_merge($input, $create);
        $createProject = Project::create($input);
        if (!empty($createProject)) {
            $result = ['success' => true, 'message' => 'Employee registeration successfully'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
            echo json_encode($result);
        }
    }
    
    /*public function basicInfo(){
        try{
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);

            if (empty($input))
            $input = Input::all();

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=', $input['projectId'])->first();
            if (empty($isProjectExist)) {
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['projectData'] = array_merge($input['projectData'], $create);
                $input['projectData']['project_id'] = $input['projectId'];
                //print_r( $input['projectData']);exit;
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
            $projectId = $input['data']['projectId'];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=',$projectId)->first();
            $input['projectData']['project_id'] = $projectId;
            
            if (!empty($input['projectImages'])) {
                if (count($input['projectImages']) > 1) {
                    unset($input['projectImages']['upload']);
                    $imagesUpload = array();
                    foreach ($input['projectImages'] as $key => $value) {
                        $isMultiple = is_array($input['projectImages'][$key]);
                        if ($isMultiple) {
                            $originalName = $input['projectImages'][$key][0]->getClientOriginalName();
                        } else {
                            $originalName = $input['projectImages']['project_logo']->getClientOriginalName();
                        }
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
                                $s3FolderName = '/project/upload';
                                $name = '';
                                $isMultiple = is_array($input['projectImages'][$key]);
                                if ($isMultiple) {
                                    for ($i = 0; $i < count($input['projectImages'][$key]); $i++) {
                                        $imageName = 'project' . $input['projectId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key][$i]->getClientOriginalExtension();
                                        S3::s3FileUpload($input['projectImages'][$key][$i]->getPathName(), $imageName, $s3FolderName);
                                        $name .= ',' . $imageName;
                                    }
                                } else {
                                    $imageName = 'project' . $input['projectId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['projectImages'][$key]->getClientOriginalExtension();
                                    S3::s3FileUpload($input['projectImages'][$key]->getPathName(), $imageName, $s3FolderName);
                                    $name .= ',' . $imageName;
                                }
                                $input['projectData'][$key] = trim($name, ',');
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

                if(isset($input['data']['inventoryData'])){
                    $isBlockExist = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['data']['inventoryData']['wing_id']])->first();
                    $input['data']['inventoryData']['project_id'] = $projectId;
                    if (empty($isBlockExist)) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input['data']['inventoryData'] = array_merge($input['data']['inventoryData'],$create);                
                        $actionProject = ProjectBlock::create($input['data']['inventoryData']);
                        $msg = "Record added successfully";
                    }else{
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input['data']['inventoryData'] = array_merge($input['data']['inventoryData'],$update);
                        $actionProject = ProjectBlock::where(['project_id' => $projectId, 'wing_id' => $input['data']['inventoryData']['wing_id']])->update($input['data']['inventoryData']);
                        $msg = "Record updated successfully";
                    }
                }           
                if(!empty($actionProject)){
                    $result = ['success' => true, 'message' => $msg];
                }else{
                    $result = ['success' => false, 'message' => 'Something went wrong.'];
                }
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
        
        if(!empty($getProjectDetails)){
//            $arr = explode(",", $getProjectDetails[0]['project_amenities_list']);
//            $getAmenities = MlstBmsbAmenity::select('id','name_of_amenity')->whereIn('id', $arr)->get();
//            $getProjectDetails[0]['project_amenities_list'] = json_encode($getAmenities);

            $result = ['success' => true, 'details' => $getProjectDetails[0]];
        }else{
            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
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

    public function getWings() {
        $projectWing = ProjectWing::select('id', 'project_id', 'wing_name')->where('project_id', 1)->get();
        if (!empty($projectWing)) {
            $result = ['success' => true, 'records' => $projectWing];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

}
