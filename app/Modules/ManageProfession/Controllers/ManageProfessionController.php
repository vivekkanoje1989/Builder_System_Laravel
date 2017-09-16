<?php

namespace App\Modules\ManageProfession\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProfession\Models\MlstProfessions;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Excel;

class ManageProfessionController extends Controller {

    public function index() {
        return view("ManageProfession::index");
    }

    public function manageProfession() {
        $getProfession = MlstProfessions::select('profession', 'status', 'id')->where('deleted_status', '!=', 1)->get();
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
        if (!empty($getProfession)) {
            $result = ['success' => true, 'records' => $getProfession,'exportData'=>$export,'delete'=>$deleteBtn];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
    public function deleteProfession() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['professionData'] = array_merge($request, $create);
        $professions = MlstProfessions::where('id', $request['id'])->update($input['professionData']);
        $result = ['success' => true, 'result' => $professions];
        return json_encode($result);
        
    }
    
    
    public function professionExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
             $getProfession = MlstProfessions::select('profession', 'status', 'id')->get();
            $getCount =MlstProfessions::select('profession', 'status', 'id')->get()->count();
            $getProfession = json_decode(json_encode($getProfession), true);
            
            $manageProfession = array();
            $j = 1;
            for ($i = 0; $i < count($getProfession); $i++) {
                $manageProfessionData['Sr No.'] = $j++;
                $manageProfessionData['Block Stage Name'] = $getProfession[$i]['profession'];
                if($getProfession[$i]['status'] == '1'){
                    $manageProfessionData['Status'] = 'Active';
                }
                else{
                     $manageProfessionData['Status'] = 'In Active';
                }
                $manageProfession[] = $manageProfessionData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Profession Details', function($excel) use($manageProfession) {
                    $excel->sheet('sheet1', function($sheet) use($manageProfession) {
                        $sheet->fromArray($manageProfession);
                    });
                })->download('xls');
            }
        }
    }
    

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstProfessions::where(['profession' => $request['profession']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Profession already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['professionData'] = array_merge($request, $create);
            $result = MlstProfessions::create($input['professionData']);
            $last3 = MlstProfessions::latest('id')->first();
            $input['professionData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstProfessions::where(['profession' => $request['profession']])->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'profession already exists'];
            return json_encode($result);
        } else {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['professionData'] = array_merge($request, $update);
            $originalValues = MlstProfessions::where('id', $request['id'])->get();
            $result = MlstProfessions::where('id', $request['id'])->update($input['professionData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
