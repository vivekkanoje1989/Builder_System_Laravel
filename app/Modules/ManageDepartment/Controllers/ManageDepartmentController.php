<?php

namespace App\Modules\ManageDepartment\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartment;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Excel;
use Illuminate\Support\Facades\Input;
use App\Modules\ManageDepartment\Models\MlstBmsbVerticals;

class ManageDepartmentController extends Controller {

    public function index() {
        return view("ManageDepartment::index");
    }

    public function manageDepartment() {
        $getDepartments = MlstBmsbDepartment::with(['vertical'])->select('department_name', 'id', 'vertical_id')
                ->where('deleted_status', '!=', 1)
                ->get();
        $i = 0;
        foreach ($getDepartments as $getDepartment) {
            $getDepartments[$i]['verticalData'] = $getDepartment['vertical']['name'];
            $i++;
        }
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

        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments, 'exportData' => $export,'delete'=>$deleteBtn];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function deleteDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['departmentData'] = array_merge($request, $create);
        $departmentData = MlstBmsbDepartment::where('id', $request['id'])->update($input['departmentData']);
        $result = ['success' => true, 'result' => $departmentData];
        return json_encode($result);
    }

    public function departmentsExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getDepartments = MlstBmsbDepartment::with(['vertical'])->select('department_name', 'id', 'vertical_id')->get();
            $k = 0;
            foreach ($getDepartments as $getDepartment) {
                $getDepartments[$k]['verticalData'] = $getDepartment['vertical']['name'];
                $k++;
            }
            $getCount = MlstBmsbDepartment::with(['vertical'])->select('department_name', 'id', 'vertical_id')->get()->count();
            $getDepartments = json_decode(json_encode($getDepartments), true);

            $manageDepartments = array();
            $j = 1;
            for ($i = 0; $i < count($getDepartments); $i++) {
                $getDepartmentsData['Sr No.'] = $j++;
                $getDepartmentsData['Department'] = $getDepartments[$i]['department_name'];
                $getDepartmentsData['Vertical Name'] = $getDepartments[$i]['verticalData'];
                $manageDepartments[] = $getDepartmentsData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Department Details', function($excel) use($manageDepartments) {
                    $excel->sheet('sheet1', function($sheet) use($manageDepartments) {
                        $sheet->fromArray($manageDepartments);
                    });
                })->download('csv');
            }
        }
    }

    public function getDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getDepartment = MlstBmsbDepartment::leftJoin('mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->where('mlst_bmsb_departments.id', $request['id'])->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbDepartment::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['departmentData'] = array_merge($request, $create);
            $result = MlstBmsbDepartment::create($input['departmentData']);
            $last3 = MlstBmsbDepartment::latest('id')->first();
            $input['departmentData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstBmsbDepartment::where(['department_name' => $request['department_name'], ['id', '!=', $id]])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $result = MlstBmsbDepartment::where('id', $id)->update($request);
            $vertical = MlstBmsbVerticals::where('id', '=', $request['vertical_id'])->first();
            $result = ['success' => true, 'result' => $result, 'vertical' => $vertical];
            return json_encode($result);
        }
    }

}
