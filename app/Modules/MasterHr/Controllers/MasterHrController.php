<?php

namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
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
//        echo "<pre>";print_r($_FILES);
        $input = Input::all();
//        $userData = json_decode($input['userData'], true);
//        echo "input<pre>";print_r($input);

        $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
//exit;
        $employee = Employee::createEmployee($input['userData']);//insert data into database
        
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************
        $input = Input::all();
        $file = $input['emp_photo_url'];
        $fileArray = array('emp_photo_url' => $file);

        $imgRules = array(
            'emp_photo_url' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
        );
        $validator = Validator::make($fileArray, $imgRules);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        else{
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $input['emp_photo_url']->move(resource_path('hrEmployeePhoto'), $fileName);
        }
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        
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
