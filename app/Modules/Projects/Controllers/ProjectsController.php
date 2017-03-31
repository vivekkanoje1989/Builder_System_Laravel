<?php

namespace App\Modules\Projects\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Projects\Models\MlstBmsbProjectStatus;
use App\Modules\Projects\Models\MlstBmsbProjectType;
use App\Modules\Projects\Models\Project;
use Auth;
use App\Classes\CommonFunctions;

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
