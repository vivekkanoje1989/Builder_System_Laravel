<?php

namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\LstBloodGroup;

class BloodGroupsController extends Controller {

    public function index() {
        return view("BmsLists::index");
    }

    public function manageBloodGroup() {
        $getBloodGroup = LstBloodGroup::all();
        if (!empty($getBloodGroup)) {
            $result = ['success' => true, 'records' => $getBloodGroup];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function createBloodGroup() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstBloodGroup::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($cnt > 0) {  //exists blood group
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['bloodGroupData'] = array_merge($request,$create);
             $bloodgroup = LstBloodGroup::create($input['bloodGroupData']);
             $last3 = LstBloodGroup::latest('blood_group_id')->first();
            $input['bloodGroupData']['main_record_id'] = $last3->blood_group_id;
             $input['bloodGroupData']['record_type'] = 1;
             $input['bloodGroupData']['record_restore_status'] = 1;
             $bloodgroupCreate = LstBloodGroupsLogs::create($input['bloodGroupData']);
          
           
            $result = ['success' => true, 'result' => $bloodgroup,'lastinsertid'=>$last3->blood_group_id];
            return json_encode($result);
        }
    }

    public function updateBloodGroup() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       $getCount = LstBloodGroup::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['bloodGroupData'] = array_merge($request,$update);
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['bloodGroupcreate'] = array_merge($request,$create);
            
            $originalValues = LstBloodGroup::where('blood_group_id', $request['blood_group_id'])->get();
            $result = LstBloodGroup::where('blood_group_id', $request['blood_group_id'])->update($input['bloodGroupData']);
            $result = ['success' => true, 'result' => $result];
             
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
             
            $input['bloodGroupcreate']['record_type'] = 2;
            $input['bloodGroupcreate']['column_names'] = $implodeArr;
            $input['bloodGroupcreate']['record_restore_status'] = 1;
            $input['bloodGroupcreate']['blood_group_id'] = '';
            $input['bloodGroupcreate']['main_record_id'] = $originalValues[0]['blood_group_id'];
            $input['bloodGroupcreate']['record_type'] = 2;
            $input['bloodGroupcreate']['record_restore_status'] = 1;
            $input['bloodGroupcreate']['created_at'] = date("Y-m-d");
            $input['bloodGroupcreate']['created_by'] = Auth::guard('admin')->user()->id;
            $input['bloodGroupcreate']['updated_by'] = Auth::guard('admin')->user()->id;
            $bloodgroupUpdate = LstBloodGroupsLogs::create($input['bloodGroupcreate']);   
            return json_encode($result);
        }
    }

}
