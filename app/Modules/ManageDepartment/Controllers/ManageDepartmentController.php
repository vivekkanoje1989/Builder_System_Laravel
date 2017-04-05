<?php

namespace App\Modules\ManageDepartment\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartments;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Illuminate\Support\Facades\Input;

class ManageDepartmentController extends Controller {

    public function index() {
        return view("ManageDepartment::index");
    }

    public function manageDepartment() {
        $getDepartment = MlstBmsbDepartments::leftJoin('mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getDepartment = MlstBmsbDepartments::leftJoin('mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->where('mlst_bmsb_departments.id', $request['id'])->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['departmentData'] = array_merge($request, $create);
            $result = MlstBmsbDepartments::create($input['departmentData']);
            $last3 = MlstBmsbDepartments::latest('id')->first();

            $getvertical = DB::connection('masterdb')->table('mlst_bmsb_verticals')->where('id', '=', $request['vertical_id'])
                    ->select('name')
                    ->first();

            $input['departmentData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id, 'vertical' => $getvertical->name];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = Input::all();
        $getCount = MlstBmsbDepartments::where(['department_name' => $request['department_name']])
                        ->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['departmentData'] = array_merge($request, $create);
            $result = MlstBmsbDepartments::where('id', $request['id'])->update($input['departmentData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
