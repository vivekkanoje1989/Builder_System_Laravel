<?php

namespace App\Modules\BloodGroups\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BloodGroups\Models\MlstBloodGroups;
use App\Classes\CommonFunctions;
use Auth;

class BloodGroupsController extends Controller {

    public function index() {
        return view("BloodGroups::index");
    }

    public function manageBloodGroups() {
        $getBloodGroup = MlstBloodGroups::all();
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

        $cnt = MlstBloodGroups::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($cnt > 0) {  //exists blood group
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['bloodGroupData'] = array_merge($request, $create);
            $bloodgroup = MlstBloodGroups::create($input['bloodGroupData']);
            $last3 = MlstBloodGroups::latest('id')->first();
            $result = ['success' => true, 'result' => $bloodgroup, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        
        $getCount = MlstBloodGroups::where(['blood_group' => $request['blood_group']])->where('id','!=',$id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['bloodData'] = array_merge($request, $update);
            $result = MlstBloodGroups::where('id', $id)->update($input['bloodData']);
            $result = ['success' => true, 'result' => $result];

            return json_encode($result);
        }
    }

}
