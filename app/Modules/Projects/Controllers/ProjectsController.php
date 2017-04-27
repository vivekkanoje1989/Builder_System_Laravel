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
                                    //find images name depending on $input['projectImages'][$key]
                                    for($i=0; $i < count($input['projectImages'][$key]); $i++){
                                        //upload image
                                        //$input['projectData'][$key] = "aa";
                                    }
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
        $projectWing = ProjectWing::select('id','project_id','wing_name')->where('project_id', 1)->get();
        if (!empty($projectWing)) {
            $result = ['success' => true, 'records' => $projectWing];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

}
