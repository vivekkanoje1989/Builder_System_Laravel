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
use Excel;

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
        } else { // index mail configuration 
            $getEmailConfigs = EmailConfiguration::select('id', 'email', 'password', 'department_id', 'status')->where('deleted_status', '!=', 1)->get();
            foreach ($getEmailConfigs as $getEmailConfig) {
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
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if ($getEmailConfigs) {
            $result = ['success' => true, 'records' => $getEmailConfigs, 'exportData' => $export,'delete'=>$deleteBtn,'departments' => $getDepartment];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
        return json_encode($result);
    }

    public function deleteEmailConfig() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['emailConfigData'] = array_merge($request, $create);
        $emailConfigData = EmailConfiguration::where('id', $request['id'])->update($input['emailConfigData']);
        $result = ['success' => true, 'result' => $emailConfigData];
        return json_encode($result);
    }

    public function configEmailExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getCount = EmailConfiguration::select('id', 'email', 'password', 'department_id', 'status')->get()->count();
            $getEmailConfigs = EmailConfiguration::select('id', 'email', 'password', 'department_id', 'status')->get();
            foreach ($getEmailConfigs as $getEmailConfig) {
                $arr = explode(',', $getEmailConfig['department_id']);
                $getDepartment = '';
                $getDepartments = MlstBmsbDepartment::whereIn('id', $arr)->select('department_name')->get();
                foreach ($getDepartments as $getDepart) {
                    $getDepartment .= ',' . $getDepart['department_name'];
                }
                $getDepartment = trim($getDepartment, ',');
                $getEmailConfig['deptName'] = $getDepartment;
            }

            $emailConfigaration = array();
            $j = 1;
            $emailConfigData = json_decode(json_encode($getEmailConfigs), true);
            for ($i = 0; $i < count($emailConfigData); $i++) {
                $emailConfig['Sr No'] = $j++;
                $emailConfig['Email'] = $emailConfigData[$i]['email'];
//                $emailConfig['Password'] = $emailConfigData[$i]['password'];
                $emailConfig['Service Provider'] = 'Gmail';
                $emailConfig['Department Name'] = $emailConfigData[$i]['deptName'];
                $emailConfigaration[] = $emailConfig;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Default Template Data', function($excel) use($emailConfigaration) {
                    $excel->sheet('sheet1', function($sheet) use($emailConfigaration) {
                        $sheet->fromArray($emailConfigaration);
                    });
                })->download('csv');
            }
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
        return view('EmailConfig::create')->with('id', 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['emaildata'])) {
            $userName = $input['emaildata']['email'];
            $password = $input['emaildata']['password'];
            $mailBody = "Testing mail " . "<br><br>" . "Thank You!";
            $companyName = config('global.companyName');
            $subject = "Mail subject";
            $data = ['mailBody' => $mailBody, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => "uma@nextedgegroup.co.in", "cc" => "geeta@nextedgegroup.co.in"];
            $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
            if ($sentSuccessfully) {
                if (!empty($input['emaildata']['departmentid'])) {
                    $input['emaildata']['department_id'] = $input['emaildata']['departmentid'];
                } else {
                    $input['emaildata']['department_id'] = implode(',', array_map(function($el) {
                                return $el['id'];
                            }, $input['emaildata']['department_id']));
                }
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['emaildata'] = array_merge($input['emaildata'], $create);
                $createEmailConfig = EmailConfiguration::create($input['emaildata']);
                if ($createEmailConfig) {
                    $result = ['success' => true, 'message' => 'Data saved successfully'];
                }
            } else {
                $result = ['success' => false, 'message' => 'Wrong email credentials'];
            }
            return json_encode($result);
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        return view('EmailConfig::update')->with('id', $id);
    }

    public function update($id) {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['emaildata'])) {

            $getAccountDetails = EmailConfiguration::select("email", "password")->where('id', $id)->get();
            echo $getAccountDetails[0]['email'] . "==" . $getAccountDetails[0]['password'];
            if (($getAccountDetails[0]['email'] != $input['emaildata']['email']) || ($getAccountDetails[0]['password'] != $input['emaildata']['password'])) {
                $userName = $input['emaildata']['email'];
                $password = $input['emaildata']['password'];
                $mailBody = "Testing mail " . "<br><br>" . "Thank You!";
                $companyName = config('global.companyName');
                $subject = "Mail subject";
                $data = ['mailBody' => $mailBody, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => "uma@nextedgegroup.co.in", "cc" => "geeta@nextedgegroup.co.in"];
                $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                if ($sentSuccessfully) {
                    
                } else {
                    $result = ['success' => false, 'message' => 'Wrong email credentials'];
                }
            }
            if (!empty($input['emaildata']['departmentid'])) {
                $input['emaildata']['department_id'] = $input['emaildata']['departmentid'];
            } else {
                $input['emaildata']['department_id'] = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $input['emaildata']['department_id']));
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['emaildata'] = array_merge($input['emaildata'], $update);
            $updateEmailConfig = EmailConfiguration::where('id', $id)->update($input['emaildata']);
            if ($updateEmailConfig) {
                $result = ['success' => true, 'message' => 'Data updated successfully'];
            }
            return json_encode($result);
        }
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
