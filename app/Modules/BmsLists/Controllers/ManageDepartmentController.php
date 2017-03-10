<?php

namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\LstDepartments;
use App\Models\LstDepartmentsLogs;

class ManageDepartmentController extends Controller {

    public function index() {
        return view("BmsLists::department");
    }

    public function manageDepartment() {
        $getDepartment = LstDepartments::all();

        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        
        $cnt = LstDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['departmentData'] = array_merge($request,$create);
             $result = LstDepartments::create($input['departmentData']);
             $last3 = LstDepartments::latest('id')->first();
            $input['departmentData']['main_record_id'] = $last3->id;
             $input['departmentData']['record_type'] = 1;
             $input['departmentData']['record_restore_status'] = 1;
             $countryCreate =LstDepartmentsLogs::create($input['departmentData']);
          
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        } 
    }

    public function updateDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        
        $getCount = LstDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['departmentData'] = array_merge($request,$update);
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['departmentcreate'] = array_merge($request,$create);
            
            $originalValues = LstDepartments::where('id', $request['id'])->get();
            $result = LstDepartments::where('id', $request['id'])->update($input['departmentData']);
            $result = ['success' => true, 'result' => $result];
             
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
             
            $input['departmentcreate']['record_type'] = 2;
            $input['departmentcreate']['column_names'] = $implodeArr;
            $input['departmentcreate']['record_restore_status'] = 1;
            $input['departmentcreate']['id'] = '';
            $input['departmentcreate']['main_record_id'] = $originalValues[0]['id'];
            $input['departmentcreate']['record_type'] = 2;
            $input['departmentcreate']['record_restore_status'] = 1;
            $input['departmentcreate']['created_at'] = date("Y-m-d");
            $input['departmentcreate']['created_by'] = Auth::guard('admin')->user()->id;
            $input['departmentcreate']['updated_by'] = Auth::guard('admin')->user()->id;
            $countryUpdate = LstDepartmentsLogs::create($input['departmentcreate']);   
            return json_encode($result);
        }
    }

}
