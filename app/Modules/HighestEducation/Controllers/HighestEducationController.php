<?php

namespace App\Modules\HighestEducation\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\HighestEducation\Models\MlstEducations;
use App\Classes\CommonFunctions;
use DB;
use Auth;
class HighestEducationController extends Controller {

    public function index() {
        return view("HighestEducation::index");
    }
    public function manageHighestEducation() {
        $getHighestEducations = MlstEducations::select('education','status','id')->get();
//         $i = 0;
//        foreach($getHighestEducations as $getHighestEducation){
//            if($getHighestEducation['status'] == 1){
//            $getHighestEducations[$i]['status'] = 'active';
//            }else{
//            $getHighestEducations[$i]['status'] = 'inactive';
//            }
//            $i++;
//        }
        if (!empty($getHighestEducations)) {
            $result = ['success' => true, 'records' => $getHighestEducations];
            return json_encode($result);
        }else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $cnt = MlstEducations::where('education','=', $request['education'])->get()->count();
        
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Education title already exists'];
            return json_encode($result);
        } else {
             $loggedInUserId = Auth::guard('admin')->user()->id; 
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['educationData'] = array_merge($request, $create);
            $result = MlstEducations::create($input['educationData']);
            $last3 = MlstEducations::latest('id')->first();
            $input['educationData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = MlstEducations::where(['education' => $request['education']])
                                    ->where('id','!=',$id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Education title already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['educationData'] = array_merge($request, $update);
            $result = MlstEducations::where('id', $id)->update($input['educationData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    
}
