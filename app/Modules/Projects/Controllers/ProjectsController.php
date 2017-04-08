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
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $request['data'] = array_merge($request['data'],$create);   
        $createProject = Project::create($request['data']);
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
            $request = json_decode($postdata, true);      
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $isProjectExist = ProjectWebPage::where('project_id', '=',$request['data']['projectId'])->first();
            if (empty($isProjectExist)) {
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $request['data']['basicData'] = array_merge($request['data']['basicData'],$create);
                $request['data']['basicData']['project_id'] = $request['data']['projectId'];
                $actionProject = ProjectWebPage::create($request['data']['basicData']);
                $msg = "Record added successfully";
            }else{
                $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                $request['data']['basicData'] = array_merge($request['data']['basicData'],$update);
                $request['data']['basicData']['project_id'] = $request['data']['projectId'];
                $actionProject = ProjectWebPage::where('project_id', $request['data']['projectId'])->update($request['data']['basicData']);
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
            echo "<pre>";print_r($input);exit;
            $arr = array();
            $arr[] = $input; 
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
                for($i = 0; $i < count($input); $i++){
                    $folderName = key($arr[$i]);
                    $imageName = S3::s3FileUplod($arr[$i][$folderName], $folderName, count($arr[$i][$folderName]));
                    $imageName = trim($imageName, ',');
                    //$actionProject = ProjectWebPage::where('project_id', $request['imagesData']['projectId'])->update($request['data']['basicData']);
//                    echo "<pre>";print_r($imageName);
                }
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
    public function getProjects() {
        $projectList = Project::select('id','project_name')->get();
        if (!empty($projectList)) {
            $result = ['success' => true, 'records' => $projectList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
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
