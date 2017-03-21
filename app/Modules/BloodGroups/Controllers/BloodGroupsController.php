<?php

namespace App\Modules\BloodGroups\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BloodGroups\Models\LstBloodGroups;
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

        $cnt = LstBloodGroups::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($cnt > 0) {  //exists blood group
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['bloodGroupData'] = array_merge($request, $create);
            $bloodgroup = LstBloodGroups::create($input['bloodGroupData']);
            $last3 = LstBloodGroups::latest('blood_group_id')->first();
            $result = ['success' => true, 'result' => $bloodgroup, 'lastinsertid' => $last3->blood_group_id];
            return json_encode($result);
        }
    }

    public function update() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstBloodGroups::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            $originalValues = LstBloodGroups::where('blood_group_id', $request['blood_group_id'])->get();
            $result = LstBloodGroups::where('blood_group_id', $request['blood_group_id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
