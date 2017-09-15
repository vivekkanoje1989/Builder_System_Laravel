<?php

namespace App\Modules\ManageProjectTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProjectTypes\Models\MlstBmsbProjectTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Excel;

class ManageProjectTypesController extends Controller {

    public function index() {
        return view("ManageProjectTypes::index");
    }

    public function manageProjectTypes() {
        $getTypes = MlstBmsbProjectTypes::select('project_type', 'id')->where('deleted_status', '!=', 1)->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if (!empty($getTypes)) {
            $result = ['success' => true, 'records' => $getTypes, 'exportData' => $export,'delete'=>$deleteBtn];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

     public function deleteProjectTypes() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['projectTypeData'] = array_merge($request, $create);
        $projectTypes = MlstBmsbProjectTypes::where('id', $request['id'])->update($input['projectTypeData']);
        $result = ['success' => true, 'result' => $projectTypes];
        return json_encode($result);
        
    }
    public function projectTypesExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getTypes = MlstBmsbProjectTypes::select('project_type', 'id')->get();
            $getCount = MlstBmsbProjectTypes::select('project_type', 'id')->get()->count();
            $getTypes = json_decode(json_encode($getTypes), true);

            $manageTypes = array();
            $j = 1;
            for ($i = 0; $i < count($getTypes); $i++) {
                $manageTypesData['Sr No.'] = $j++;
                $manageTypesData['Project Type'] = $getTypes[$i]['project_type'];
                $manageTypes[] = $manageTypesData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Project Type Details', function($excel) use($manageTypes) {
                    $excel->sheet('sheet1', function($sheet) use($manageTypes) {
                        $sheet->fromArray($manageTypes);
                    });
                })->download('xls');
            }
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbProjectTypes::where(['project_type' => $request['project_type']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['projectTypeData'] = array_merge($request, $create);
            $result = MlstBmsbProjectTypes::create($input['projectTypeData']);
            $last3 = MlstBmsbProjectTypes::latest('id')->first();
            $input['projectTypeData']['id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstBmsbProjectTypes::where(['project_type' => $request['project_type']])
                ->where('id', '!=', $id)
                ->get()
                ->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {
            $result = MlstBmsbProjectTypes::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
