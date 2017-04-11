<?php

namespace App\Modules\Projects\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Projects\Models\MlstBmsbProjectStatus;
use App\Modules\Projects\Models\MlstBmsbProjectType;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectWebPage;
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
        $input = array_merge($input,$create);   
        $createProject = Project::create($input);
        if(!empty($createProject)){
            $result = ['success' => true, 'message' => 'Employee registeration successfully'];
            echo json_encode($result);
        }else{
            $result = ['success' => false, 'message' => 'Something went wrong. Record not created.'];
            echo json_encode($result);
        }
    }
    
    public function basicInfo(){
        try{
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);  
            if(empty($input))
                $input = Input::all();
            //echo "<Pre>";print_r($input);
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=',$input['projectId'])->first();
            if (empty($isProjectExist)) {
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['projectData'] = array_merge($input['projectData'],$create);
                $input['projectData']['project_id'] = $input['projectId'];
                $actionProject = ProjectWebPage::create($input['projectData']);
                $msg = "Record added successfully";
            }else{
                if(isset($input['projectData'])){
                    $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                    $input['projectData'] = array_merge($input['projectData'],$update);
                }
                if(!empty($input['projectImages'])){
                    if(count($input['projectImages']) > 1){
                        unset($input['projectImages']['upload']);
                        
                        foreach($input['projectImages'] as $key => $value){                            
                            $originalName = $input['projectImages'][$key]->getClientOriginalName();
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
                                    $input['projectData'][$key] = "aa";
                                }
                            }
                        } 
                    }
                }
                if(isset($input['projectData'])){
                    $actionProject = ProjectWebPage::where('project_id', $input['projectId'])->update($input['projectData']);
                }
                $msg = "Record updated successfully";
            }
            if(!empty($actionProject)){
                $result = ['success' => true, 'message' => $msg];
                echo json_encode($result);
            }else{
                $result = ['success' => false, 'message' => 'Something went wrong.'];
                echo json_encode($result);
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }
    public function imagesInfo() {
        try{
            $input = Input::all();
            
            unset($input['imagesData']['upload']);
            $arr[] = $input['imagesData'];             
            $imgRules = array(
                'project_logo' => 'mimes:jpeg,png,jpg,gif,svg',
                'project_thumbnail' => 'mimes:jpeg,png,jpg,gif,svg',
                'project_favicon' => 'mimes:jpeg,png,jpg,gif,svg',
                'project_banner_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                'project_background_images.*' => 'mimes:jpeg,png,jpg,gif,svg',
                'project_broacher.*' => 'mimes:jpeg,png,jpg,gif,svg',
            );
            $validator = Validator::make($input, $imgRules);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result);
            } else {
                for($i = 0; $i < count($arr); $i++){
                    $folderName = key($arr[$i]);
                    echo count($arr[$i][$folderName]);exit;
                    $imageName = S3::s3FileUplod($arr[$i][$folderName], $folderName, count($arr[$i][$folderName]));
                    if(count($arr[$i][$folderName]) > 1){
                        $imageName = trim($imageName, ',');
                    }
                    echo "<pre>";print_r($input);
                    $user = ProjectWebPage::where ("project_id",  $input['imagesData']['projectId']);
                    $user->fill([$arr[$i][$folderName] => $imageName]);
                    $user->save();

//                    $actionProject = ProjectWebPage::where('project_id', $input['imagesData']['projectId'])->update($input['projectData']);
//                    echo "<pre>";print_r($imageName);
                }exit;
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
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
//    public function getProjects() {
//        $projectList = Project::select('id','project_name')->get();
//        if (!empty($projectList)) {
//            $result = ['success' => true, 'records' => $projectList];
//            return json_encode($result);
//        } else {
//            $result = ['success' => false, 'message' => 'Something went wrong'];
//            return json_encode($result);
//        }
//    }
    public function projectType() {
        $typeList = MlstBmsbProjectType::all();
        if (!empty($typeList)) {
            $result = ['success' => true, 'records' => $typeList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function projectStatus() {
        $typeStatus = MlstBmsbProjectStatus::all();
        if (!empty($typeStatus)) {
            $result = ['success' => true, 'records' => $typeStatus];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    

}
