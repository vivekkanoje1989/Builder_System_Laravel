<?php

namespace App\Modules\HighestEducation\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\HighestEducation\Models\LstEducations;
use App\Classes\CommonFunctions;
use DB;

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
        $getHighestEducation = LstEducations::all();

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

        $cnt = LstEducations::where(['education_title' => $request['education_title']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Education title already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['educationData'] = array_merge($request, $create);
            $result = LstEducations::create($input['educationData']);
            $last3 = LstEducations::latest('education_id')->first();
            $input['educationData']['main_record_id'] = $last3->education_id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->education_id];
            return json_encode($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = LstEducations::where(['education_title' => $request['education_title']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['educationData'] = array_merge($request, $update);

            $originalValues = LstEducations::where('education_id', $request['education_id'])->get();
            $result = LstEducations::where('education_id', $request['education_id'])->update($input['educationData']);

            $last = DB::connection('masterdb')->table('lst_educations_logs')->latest('education_id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::connection('masterdb')->table('lst_educations_logs')->where('education_id', $last->education_id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
