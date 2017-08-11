<?php

namespace App\Modules\CloudTelephony\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmployeesDevice;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
use DB;
use Illuminate\Http\Request;
use App\Models\CtTuneType;
use App\Models\CtForwardingType;
use App\Models\EnquirySubSource;
use App\Models\CtSetting;
use App\Models\backend\Employee;
use App\Models\CtEmployeesExtension;
use \App\Models\MlstLmsaDesignation;
use App\Classes\S3;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\CtEmployeesExtensionsLog;

class ExtensionEmployeeController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

    public function viewextemployee() {
        return view("CloudTelephony::extensionemplist");
    }

    public function getCtEmployeeExtension() {
        $ctEmployeesExtension = CtEmployeesExtension::select('ct_employees_extensions.extension_no', 'ct_employees_extensions.id', 'emp.id as employee_id', 'emp.first_name', 'emp.first_name', 'emp.last_name', 'mld.designation')
                ->leftjoin('employees as emp', 'emp.id', '=', 'ct_employees_extensions.employee_id')
                ->leftjoin('lmsauto_master_final.mlst_lmsa_designations as mld', 'mld.id', '=', 'emp.designation_id')
                ->orderBy('ct_employees_extensions.id', 'ASC')
                ->get();

        if (!empty($ctEmployeesExtension)) {
            $result = ['success' => true, 'records' => $ctEmployeesExtension];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getExtensionEmployee() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        for ($i = 0; $i < count($input['employees']); $i++) {
            $emp_ids[] = $input['employees'][$i]['employee_id'];
        }

        if (!empty($emp_ids)) {
            $emp = @implode(',', $emp_ids);
            $ExtensionEmployees = Employee::select('employees.id as id', 'employees.first_name', 'employees.last_name', 'mld.designation')->leftjoin('lmsauto_master_final.mlst_lmsa_designations as mld', 'mld.id', '=', 'employees.designation_id')->whereRaw("employees.id NOT IN($emp)")->get();
        } else {

            $ExtensionEmployees = Employee::select('employees.id as id', 'employees.first_name', 'employees.last_name', 'mld.designation')->leftjoin('lmsauto_master_final.mlst_lmsa_designations as mld', 'mld.id', '=', 'employees.designation_id')->get();
        }

        $numbers = range(0, 99);
        $arr = array(0);
        $extenion = array_diff($numbers, $arr);

        $extension_number = CtEmployeesExtension::select('extension_no')->get();
        if (!empty($extension_number)) {
            $num = array();
            foreach ($extension_number as $extno) {
                $num[] = $extno['extension_no'];
            }
            $extenion = array_diff($extenion, $num);
            if (!empty($input['listNumber'])) {
                $existext[$input['listNumber']['extension_no']] = $input['listNumber']['extension_no'];
                $extenion = $existext + $extenion;
            }
        }

        if (!empty($ExtensionEmployees)) {
            $final = '';
            for ($i = 0; $i < count($ExtensionEmployees); $i++) {
                $final[$i]['id'] = $ExtensionEmployees[$i]['id'];
                $final[$i]['first_name'] = $ExtensionEmployees[$i]['first_name'] . ' ' . $ExtensionEmployees[$i]['last_name'];
                $final[$i]['designation'] = $ExtensionEmployees[$i]['designation'];
            }
            $result = ['success' => true, 'records' => $final, 'extesion_no' => $extenion];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function createExtEmployee() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else if (empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        if (empty($input)) {
            $input = Input::all();
        }
        $empId = $extNo = '';
        if (!empty($input['extensionData']['employee_id'])) {
            $empId = $input['extensionData']['employee_id'];
        }
        if (!empty($input['extensionData']['extension_no'])) {
            $extNo = $input['extensionData']['extension_no'];
        }

        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        if (!empty($empId) && !empty($extNo)) {

            $existEmployee = CtEmployeesExtension::where('employee_id', '=', $empId)->first();
            if (empty($existEmployee)) {
                $input['extData']['employee_id'] = $empId;
                $input['extData']['extension_no'] = $extNo;
                $input['extData']['client_id'] = config('global.client_id');

                $input['extensionData'] = array_merge($input['extData'], $create);
                $createExtension = CtEmployeesExtension::create($input['extensionData']);
                $CtEmployeesExtensionsLog = CtEmployeesExtensionsLog::create($input['extensionData']);
                $input['customerData']['main_record_id'] = $createExtension->id;
                $input['customerData']['record_type'] = 1;
                $input['customerData']['record_restore_status'] = 1;
                if ($CtEmployeesExtensionsLog) {
                    $result = ["success" => true, "records" => $createExtension, "flag" => 'create'];
                }
            } else {
                $input['extData']['employee_id'] = $existEmployee->employee_id;
                $input['extData']['extension_no'] = $extNo;
                
                $input['extData']['client_id'] = config('global.client_id');
                $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                $input['extensionData'] = array_merge($input['extData'], $update);
                
                $updateExtension = CtEmployeesExtension::where('employee_id', $existEmployee->employee_id)->update($input['extensionData']);
                $CtEmployeesExtensionsLog = CtEmployeesExtensionsLog::create($input['extensionData']);
                $input['customerData']['main_record_id'] = $existEmployee->id;
                $input['customerData']['record_type'] = 2;
                $input['customerData']['record_restore_status'] = 1;

                if ($CtEmployeesExtensionsLog) {
                    $result = ["success" => true, "records" => $updateExtension, "flag" => 'update'];
                }
            }
        } else {
            $result = ["success" => true, "message" => "Something went wrong !!"];
        }
        return json_encode($result);
    }
}
