<?php

namespace App\Modules\ManageProfession\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProfession\Models\MlstProfessions;
use DB;
use App\Classes\CommonFunctions;
use Auth;
class ManageProfessionController extends Controller {

    public function index() {
        return view("ManageProfession::index");
    }
    public function manageProfession() {
        $getProfession = MlstProfessions::select('profession','status','id')->get();

        if (!empty($getProfession)) {
            $result = ['success' => true, 'records' => $getProfession];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
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

        $getCount = MlstProfessions::where(['profession' => $request['profession']])->where('id','!=',$id)->get()->count();
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
