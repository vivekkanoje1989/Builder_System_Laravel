<?php

namespace App\Modules\ManageDepartment\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageDepartment\Models\LstDepartments;
use DB;
use App\Classes\CommonFunctions;
class ManageDepartmentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageDepartment::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageDepartment() {
        $getDepartment = LstDepartments::all();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['departmentData'] = array_merge($request, $create);
            $result = LstDepartments::create($input['departmentData']);
            $last3 = LstDepartments::latest('id')->first();
            $input['departmentData']['main_record_id'] = $last3->id;
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

        $getCount = LstDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['departmentData'] = array_merge($request, $update);
            $originalValues = LstDepartments::where('id', $request['id'])->get();
            $result = LstDepartments::where('id', $request['id'])->update($input['departmentData']);

            $last = DB::connection('masterdb')->table('lst_departments_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::connection('masterdb')->table('lst_departments_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
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
