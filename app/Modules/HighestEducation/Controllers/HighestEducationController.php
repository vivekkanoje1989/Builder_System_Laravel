<?php

namespace App\Modules\HighestEducation\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\HighestEducation\Models\MlstEducations;
use App\Classes\CommonFunctions;
use DB;
use Auth;
use Excel;

class HighestEducationController extends Controller {

    public function index() {
        return view("HighestEducation::index");
    }

    public function manageHighestEducation() {
        $getHighestEducations = MlstEducations::select('education', 'status', 'id')->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($getHighestEducations)) {
            $result = ['success' => true, 'records' => $getHighestEducations, 'exportData' => $export];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
    public function highestEducationExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
           $getHighestEducations = MlstEducations::select('education', 'status', 'id')->get();
            $getCount =MlstEducations::select('education', 'status', 'id')->get()->count();
            $getHighestEducations = json_decode(json_encode($getHighestEducations), true);
            
            $manageHighestEducations = array();
            $j = 1;
            for ($i = 0; $i < count($getHighestEducations); $i++) {
                 $highestEducationsData['Sr No.'] = $j++;
                $highestEducationsData['Education'] = $getHighestEducations[$i]['education'];
                if($getHighestEducations[$i]['status']=='1'){
                    $highestEducationsData['status'] = 'Active';
                }else{
                    $highestEducationsData['status'] = 'In Active';
                }
                
                $manageHighestEducations[] = $highestEducationsData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Highest Educations Details', function($excel) use($manageHighestEducations) {
                    $excel->sheet('sheet1', function($sheet) use($manageHighestEducations) {
                        $sheet->fromArray($manageHighestEducations);
                    });
                })->download('xls');
            }
        }
    }
    

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstEducations::where('education', '=', $request['education'])->get()->count();

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
                        ->where('id', '!=', $id)->get()->count();
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
