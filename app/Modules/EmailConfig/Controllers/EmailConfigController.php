<?php

namespace App\Modules\EmailConfig\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\EmailConfig\Models\EmailConfiguration;
use Illuminate\Http\Request;

class EmailConfigController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("EmailConfig::index");
    }

    public function manageEmails() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['id'] === 0) {
            $getEmailConfigs = EmailConfiguration::select('id', 'email', 'password', 'department_id', 'status')->get();
            foreach ($getEmailConfigs as $getEmailConfig) {
                $getEmailConfig['email'] = base64_decode($getEmailConfig['email']);
                //$getEmailConfig['password'] = base64_decode($getEmailConfig['password']);
            }
        }
        else
        {
            
        }
        if (!empty($getEmailConfig)) {
            $result = ['success' => true, 'records' => $getEmailConfigs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
       return view('EmailConfig::manageEmailConfig')->with('id',$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
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
