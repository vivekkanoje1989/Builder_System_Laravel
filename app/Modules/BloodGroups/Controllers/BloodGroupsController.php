<?php

namespace App\Modules\BloodGroups\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BloodGroups\Models\LstBloodGroup;
use App\Classes\CommonFunctions;

class BloodGroupsController extends Controller {

    public function index() {
        return view("BloodGroups::index");
    }

    public function manageBloodGroup() {
        $getBloodGroup = LstBloodGroups::all();
        if (!empty($getBloodGroup)) {
            $result = ['success' => true, 'records' => $getBloodGroup];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
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
             $result = ['success' => true, 'result' => $bloodgroup,'lastinsertid'=>$last3->blood_group_id];
          return json_encode($result);
        }
    }

    public function update() {
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
             
         return json_encode($result);
        }
    }

}
