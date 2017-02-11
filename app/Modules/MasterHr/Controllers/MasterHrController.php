<?php

namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
class MasterHrController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {   
        return view("MasterHr::index");
    }
    
    public function manageUsers() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        echo "<pre>";print_r($request);exit;
        if(!empty($request['empId'])){
            $manageUsers = DB::select('CALL proc_manage_users(1,'.$request["empId"].')');
        }else{
            $manageUsers = DB::select('CALL proc_manage_users(0,0)');
        }
        
        if ($manageUsers) {            
            $result = ['success' => true, "records" => ["data" => $manageUsers, "total" => count($manageUsers), 'per_page' => count($manageUsers), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageUsers)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }
    public function changePassword() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if(!empty($request['empId'])){
            //send mail
            //send email
            $strRandomNo = str_random(6);
            $changedPassword = \Hash::make($strRandomNo);
            echo $strRandomNo;
            DB::table('employees')
            ->where('id', $request['empId'])
            ->update(['password' => $changedPassword]);
            
            $result = ['success' => true, "successMsg" => "Password has been changed as well as Mail and sms has been sent to selected user."];
            echo json_encode($result);
        }else{
            $result = ['success' => false, 'errorMsg' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("MasterHr::create")->with("empId", '');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $input = Input::all();

        $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
                
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        
        $imgRules = array(
            'emp_photo_url' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
        );
        $validateEmpPhotoUrl = Validator::make($input, $imgRules);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        else{
            $fileName = time().'.'.$input['emp_photo_url']->getClientOriginalExtension();
            $input['emp_photo_url']->move(resource_path('hrEmployeePhoto'), $fileName);
        }
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        $input['userData']['emp_photo_url'] = $fileName;
        $employee = Employee::createEmployee($input['userData']);//insert data into database

        if ($employee) {
            $result = ['success' => true, 'message' => 'Employee registeration successfully'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
        exit;
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
        return view("MasterHr::create")->with("empId", $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
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
