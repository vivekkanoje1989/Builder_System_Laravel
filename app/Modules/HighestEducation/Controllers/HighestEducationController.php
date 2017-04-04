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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("HighestEducation::index");
    }

    public function manageHighestEducation() {
        $getHighestEducation = MlstEducations::all();

        if (!empty($getHighestEducation)) {
            $result = ['success' => true, 'records' => $getHighestEducation];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstEducations::where(['education_title' => $request['education_title']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Education title already exists'];
            return json_encode($result);
        } else {
             $loggedInUserId = Auth::guard('admin')->user()->id; 
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['educationData'] = array_merge($request, $create);
            $result = MlstEducations::create($input['educationData']);
            $last3 = MlstEducations::latest('education_id')->first();
            $input['educationData']['main_record_id'] = $last3->education_id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->education_id];
            return json_encode($result);
        }
    }
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstEducations::where(['education_title' => $request['education_title']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
            $result = MlstEducations::where('education_id', $request['education_id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    
}
