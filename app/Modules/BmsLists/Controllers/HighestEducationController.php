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
use App\Models\LstEducation;
use App\Models\LstEducationsLogs;

class HighestEducationController extends Controller {

    public function index() {
        return view("BmsLists::highesteducation");
    }

    public function manageHighestEducation() {
        $getHighestEducation = LstEducation::all();

        if (!empty($getHighestEducation)) {
            $result = ['success' => true, 'records' => $getHighestEducation];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function createHighestEducation() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

         $cnt = LstEducation::where(['education_title' => $request['education_title']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'Education title already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['educationData'] = array_merge($request,$create);
             $result = LstEducation::create($input['educationData']);
             $last3 = LstEducation::latest('id')->first();
            $input['educationData']['main_record_id'] = $last3->id;
             $input['educationData']['record_type'] = 1;
             $input['educationData']['record_restore_status'] = 1;
             $countryCreate =LstCountriesLogs::create($input['educationData']);
          
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        }
        
    }

    public function updateHighestEducation() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstEducation::where(['education_title' => $request['education_title']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Education title  already exists'];
            return json_encode($result);
        } else {
            $result = LstEducation::where('education_id', $request['education_id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
        
        
        
        
        
         $getCount = LstEducation::where(['education_title' => $request['education_title']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['countryData'] = array_merge($request,$update);
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['countrycreate'] = array_merge($request,$create);
            
            $originalValues = LstCountries::where('id', $request['id'])->get();
            $result = LstCountries::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];
             
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
             
            $input['countrycreate']['record_type'] = 2;
            $input['countrycreate']['column_names'] = $implodeArr;
            $input['countrycreate']['record_restore_status'] = 1;
            $input['countrycreate']['id'] = '';
            $input['countrycreate']['main_record_id'] = $originalValues[0]['id'];
            $input['countrycreate']['record_type'] = 2;
            $input['countrycreate']['record_restore_status'] = 1;
            $input['countrycreate']['created_at'] = date("Y-m-d");
            $input['countrycreate']['created_by'] = Auth::guard('admin')->user()->id;
            $input['countrycreate']['updated_by'] = Auth::guard('admin')->user()->id;
            $countryUpdate = LstCountriesLogs::create($input['countrycreate']);   
            return json_encode($result);
        }
    }

}
