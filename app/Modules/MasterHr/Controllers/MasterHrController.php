<?php

namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;

class MasterHrController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("MasterHr::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("MasterHr::create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $validator = Validator::make($request['data']['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        
        
        $employee = Employee::createEmployee($request['data']['userData']);

        echo "<pre>";
        print_r($_FILES);
        //insert data into database
        if ($employee->id) {
            $result = ['success' => true, 'message' => 'Admin register successfully'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Admin not register. Please try again'];
            echo json_encode($result);
        }
        exit;
    }

    public function uploadFile(Request $request) {
        echo "<pre>";
        print_r($_FILES);
        move_uploaded_file($_FILES['file']['tmp_name'], resource_path() . '/hrEmployeePhoto/' . $_FILES['file']['name']);

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
        //
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
