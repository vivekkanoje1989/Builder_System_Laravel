<?php

namespace App\Modules\ManageLocation\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageLocation\Models\MlstLocationTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class ManageLocationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageLocation::index");
    }

    public function manageLocation() {
        $getLocation = MlstLocationTypes::all();
        if (!empty($getLocation)) {
            $result = ['success' => true, 'records' => $getLocation];
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


        $cnt = MlstLocationTypes::where(['location_type' => $request['location_type']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id; 
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['locationData'] = array_merge($request, $create);
            $result = MlstLocationTypes::create($input['locationData']);
            $last3 = MlstLocationTypes::latest('id')->first();
            $input['locationData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
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

        $getCount = MlstLocationTypes::where(['location_type' => $request['location_type']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Location already exists'];
            return json_encode($result);
        } else {

            $result = MlstLocationTypes::where('id', $request['id'])->update($request);
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
