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
use App\Models\LstProfession;

class ManageProfessionController extends Controller {

    public function index() {
        return view("BmsLists::Profession");
    }

    public function manageProfession() {
        $getProfession = LstProfession::all();

        if (!empty($getProfession)) {
            $result = ['success' => true, 'records' => $getProfession];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createProfession() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstProfession::where(['profession' => $request['profession']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'Profession already exists'];
            return json_encode($result);
        } else {
            $getResult = LstProfession::create($request);
            $result = ['success' => true, 'result' => $getResult];
            return json_encode($result);
        }
    }

    public function updateProfession() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstProfession::where(['profession' => $request['profession']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Profession already exists'];
            return json_encode($result);
        } else {
            $result = LstProfession::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
