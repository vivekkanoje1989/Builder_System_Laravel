<?php

namespace App\Modules\UserDocuments\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Classes\CommonFunctions;
use App\Modules\UserDocuments\Models\EmployeeDocuments;
use App\Modules\EmployeeDocuments\Models\MlstEmployeeDocuments;
use App\Classes\S3;
use Validator;

class UserDocumentsController extends Controller {

    public function index() {
        return view("UserDocuments::index");
    }

    public function getUsers() {

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                ->Join('employees as db2', 'db1.id', '=', 'db2.designation_id')
                ->select(["db2.first_name", "db2.last_name", "db2.id", "db1.designation"])
                ->where('db2.id', '!=', $loggedInUserId)
                ->where('db2.employee_status', '=', 1)
                ->get();
        if (!empty($employees)) {
            $result = ['success' => true, 'records' => $employees];
        } else {
            $result = ['success' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getdocuments() {
        $result = MlstEmployeeDocuments::all();
        if (!empty($result)) {
            $result = ['success' => true, 'records' => $result];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

//
    public function removeImage() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $name = $request['document'];
        $s3FolderName = '/Employee-Documents/';
        $path = $s3FolderName . $name;

        $msg = S3::s3FileDelete($name, $s3FolderName);

        $updatedata = EmployeeDocuments::where('id', $request['id'])->update(['document_url' => '']);
    }

    public function store() {

        $validationMessages = EmployeeDocuments::validationMessages();
        $validationRules = EmployeeDocuments::validationRules();
        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input, $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }

        $cnt = EmployeeDocuments::where(['document_id' => $input['document_id']])->where(['employee_id' => $input['employee_id']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errorMsgg' => 'Document already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['documentUrl']['documentUrl'])) {
                $originalName = $input['documentUrl']['documentUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {

                    $s3FolderName = 'Employee-Documents';
                    $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['documentUrl']['documentUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['documentUrl']['documentUrl']->getPathName(), $imageName, $s3FolderName);
                    $document_url = $imageName;
                } else {
                    unset($input['documentUrl']);
                    $document_url = '';
                }
            }
            $doc = MlstEmployeeDocuments::where('id', $input['document_id'])->first();
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create = array_merge($input, $common);
            $create['client_id'] = $loggedInUserId;
            $create['document_url'] = $document_url;
            $results = EmployeeDocuments::create($create);
            $last3 = EmployeeDocuments::latest('id')->first();

            return json_encode(['result' => $results, 'doc' => $doc->document_name, 'document_url' => $document_url, 'lastinsertid' => $last3->id, 'success' => true]);
        }
    }

    public function edit() {
        $input = Input::all();
        $cnt = EmployeeDocuments::where(['document_id' => $input['document_id']])->where('employee_id','=', $input['employee_id'])->get()->count();
      
        if ($cnt > 1) {
            $result = ['success' => false, 'errorMsgg' => 'Document already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['documentUrl']['documentUrl'])) {
                $originalName = $input['documentUrl']['documentUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {

                    $s3FolderName = 'Employee-Documents';
                    $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['documentUrl']['documentUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['documentUrl']['documentUrl']->getPathName(), $imageName, $s3FolderName);
                    $document_url = $imageName;
                } else {
                    unset($input['documentUrl']);
                    $document_url = '';
                }
            }
            $doc = MlstEmployeeDocuments::where('id', $input['document_id'])->first();
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create = array_merge($input, $common);
            $create['client_id'] = $loggedInUserId;
            $create['document_url'] = $document_url;
            unset($create['documentUrl']);
            $results = EmployeeDocuments::where('id', '=', $input['id'])->update($create);
            return json_encode(['result' => $results, 'doc' => $doc->document_name, 'document_url' => $document_url, 'success' => true]);
        }
    }

    public function userDocumentLists() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $users = EmployeeDocuments::with(['userDocuments'])->where('employee_id', '=', $request['employee_id'])->get();
        //$users = EmployeeDocuments::join('laravel_developement_master_edynamics.mlst_employee_documents as mlst_employee_documents', 'mlst_employee_documents.id', '=', 'employee_documents.document_id')->where('employee_documents.employee_id', '=', $request['employee_id'])->get();
        return json_encode(['result' => $users, 'success' => true]);
    }

}
