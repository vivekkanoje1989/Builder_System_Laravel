<?php

namespace App\Modules\EmailConfig\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\EmailConfig\Models\EmailConfiguration;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use App\Mail\emailconfig;
use Illuminate\Support\Facades\Mail;
use App\Models\MlstBmsbVertical;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartment;
use Auth;

class EmailConfigController extends Controller {

    public function index() {
        return view("EmailConfig::index");
    }

    public function manageEmails() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['id'] > 0) { //  update mail Configuration
            $getEmailConfigs = EmailConfiguration::where('id', $input['id'])->get();
            $arr = explode(',', $getEmailConfigs[0]['department_id']);
            $getDepartment = MlstBmsbDepartment::whereIn('id', $arr)->get();
            //$getEmailConfigs[0]['password'] = base64_decode($getEmailConfigs[0]['password']);
        } else { // index mail configuration 
            $getEmailConfigs = EmailConfiguration::select('id', 'email', 'password', 'department_id', 'status')->get();
            foreach ($getEmailConfigs as $getEmailConfig) {
                //$getEmailConfig['password'] = base64_decode($getEmailConfig['password']);
                $arr = explode(',', $getEmailConfig['department_id']);
                $getDepartment = '';
                $getDepartments = MlstBmsbDepartment::whereIn('id', $arr)->select('department_name')->get();
                foreach ($getDepartments as $getDepart) {
                    $getDepartment .= ',' . $getDepart['department_name'];
                }
                $getDepartment = trim($getDepartment, ',');
                $getEmailConfig['deptName'] = $getDepartment;
            }
        }

        if ($getEmailConfigs) {
            $result = ['success' => true, 'records' => $getEmailConfigs, 'departments' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public function testEmail() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $userName = $input['email'];
        $password = $input['password'];
        $mailBody = "Testing mail " . "<br><br>" . "Thank You!";
        $companyName = config('global.companyName');
        $subject = "Mail subject";
        $data = ['mailBody' => $mailBody, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => "uma@nextedgegroup.co.in", "cc" => "geeta@nextedgegroup.co.in"];
        $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
        if ($sentSuccessfully) {
            $result = ['success' => true, 'message' => 'Mail Sent Successfully.'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Wrong Credentials.'];
            return json_encode($result);
        }
    }

    public function create() {
        return view('EmailConfig::createNewAccount')->with('id', 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
       // $input['emaildata']['password'] = base64_encode($input['emaildata']['password']);
        if (!empty($input['emaildata']['departmentid'])) {
            $input['emaildata']['department_id'] = $input['emaildata']['departmentid'];
        } else {
            $input['emaildata']['department_id'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $input['emaildata']['department_id']));
        }
        if (!empty($input['emaildata']['loggedInUserId'])) {
            $loggedInUserId = $input['emaildata']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['emaildata'] = array_merge($input['emaildata'], $create);

        $createEmailConfig = EmailConfiguration::create($input['emaildata']);

        if ($createEmailConfig) {
            $result = ['success' => true, 'message' => 'Account Created Successfully.'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        return view('EmailConfig::manageEmailConfig')->with('id', $id);
    }

    public function update($id) {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (!empty($input['emaildata']['departmentid'])) {
            $input['emaildata']['department_id'] = $input['emaildata']['departmentid'];
        } else {
            $input['emaildata']['department_id'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $input['emaildata']['department_id']));
        }

        if (!empty($input['emaildata']['loggedInUserId'])) {
            $loggedInUserId = $input['emaildata']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['emaildata'] = array_merge($input['emaildata'], $update);
        $updateEmailConfig = EmailConfiguration::where('id', $id)->update($input['emaildata']);
        $result = ['success' => true, 'message' => 'Account Updated Successfully.'];
        return json_encode($result);
    }

    public function destroy($id) {
        
    }

    public function getDepartments() {
        $getDepartments = MlstBmsbDepartment::all();
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
