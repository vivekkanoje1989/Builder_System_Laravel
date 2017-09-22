<?php

namespace App\Modules\Designations\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Designations\Models\MlstBmsbDesignations;
use Illuminate\Http\Request;
use Auth;
use Excel;
use App\Classes\CommonFunctions;

class DesignationsController extends Controller {

    public function index() {
        return view("Designations::index");
    }

    public function manageDesignations() {
        $getDesignations = MlstBmsbDesignations::select('designation', 'status', 'id')->where('deleted_status', '!=', 1)->get();
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
        if (!empty($getDesignations)) {
            $result = ['success' => true, 'records' => $getDesignations, 'exportData' => $export, 'delete' => $deleteBtn];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function deleteDesignation() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['designationData'] = array_merge($request, $create);
        $designationData = MlstBmsbDesignations::where('id', $request['id'])->update($input['designationData']);
        $result = ['success' => true, 'result' => $designationData];
        return json_encode($result);
    }

    public function designationExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getDesignations = MlstBmsbDesignations::select('designation', 'status', 'id')->get();
            $getCount = MlstBmsbDesignations::select('designation', 'status', 'id')->get()->count();
            $getDesignations = json_decode(json_encode($getDesignations), true);

            $manageDesignations = array();
            $j = 1;
            for ($i = 0; $i < count($getDesignations); $i++) {
                $manageDesignationsData['Sr No.'] = $j++;
                $manageDesignationsData['Designation'] = $getDesignations[$i]['designation'];
                if ($getDesignations[$i]['status'] == '1') {
                    $manageDesignationsData['Status'] = 'Active';
                } else {
                    $manageDesignationsData['Status'] = 'In Active';
                }

                $manageDesignations[] = $manageDesignationsData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Designation Details', function($excel) use($manageDesignations) {
                    $excel->sheet('sheet1', function($sheet) use($manageDesignations) {
                        $sheet->fromArray($manageDesignations);
                    });
                })->download('csv');
            }
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbDesignations::where(['designation' => $request['designation']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Designation already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['designationsData'] = array_merge($request, $create);
            $result = MlstBmsbDesignations::create($input['designationsData']);
            $last3 = MlstBmsbDesignations::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstBmsbDesignations::where(['designation' => $request['designation']])
                        ->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Designation already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['designationData'] = array_merge($request, $update);
            $originalValues = MlstBmsbDesignations::where('id', $id)->get();
            $result = MlstBmsbDesignations::where('id', $id)->update($input['designationData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
