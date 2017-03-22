<?php

namespace App\Modules\ManageProfession\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProfession\Models\LstProfessions;
use DB;
use App\Classes\CommonFunctions;
class ManageProfessionController extends Controller {

    public function index() {
        return view("ManageProfession::index");
    }
    public function manageProfession() {
        $getProfession = LstProfessions::all();

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

        $cnt = LstProfessions::where(['profession' => $request['profession']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Profession already exists'];
            return json_encode($result);
        } else {
            $create = CommonFunctions::insertMainTableRecords();
            $input['professionData'] = array_merge($request, $create);
            $result = LstProfessions::create($input['professionData']);
            $last3 = LstProfessions::latest('id')->first();
            $input['professionData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = LstProfessions::where(['profession' => $request['profession']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'profession already exists'];
          return json_encode($result);
        } else {

            $originalValues = LstProfessions::where('id', $request['id'])->get();
            $result = LstProfessions::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
          return json_encode($result);
        }
    }
}
