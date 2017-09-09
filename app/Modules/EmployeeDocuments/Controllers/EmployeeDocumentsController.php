<?php

namespace App\Modules\EmployeeDocuments\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\EmployeeDocuments\Models\MlstEmployeeDocuments;
use Illuminate\Http\Request;
use Auth;
use Excel;
use App\Classes\CommonFunctions;

class EmployeeDocumentsController extends Controller {

    public function index() {
        return view("EmployeeDocuments::index");
    }

    public function employeeDocuments() {
        $result = MlstEmployeeDocuments::select('document_name', 'id')->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($result)) {
            $result = ['success' => true, 'records' => $result,'exportData'=>$export];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageDocumentExportToExcel() {
         $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $result = MlstEmployeeDocuments::select('document_name', 'id')->get();
            $getCount = MlstEmployeeDocuments::select('document_name', 'id')->get()->count();
            $result = json_decode(json_encode($result), true);
            
            $manageDocuments = array();
            $j = 1;
            for ($i = 0; $i < count($result); $i++) {
                 
                $documentData['Sr No.'] = $j++;
                $documentData['Document Name'] = $result[$i]['document_name'];
                $manageDocuments[] = $documentData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Documents', function($excel) use($manageDocuments) {
                    $excel->sheet('sheet1', function($sheet) use($manageDocuments) {
                        $sheet->fromArray($manageDocuments);
                    });
                })->download('xls');
            }
        }
    }
    
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstEmployeeDocuments::where(['document_name' => $request['document_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errorMsg' => 'Document name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['documentData'] = array_merge($request, $create);
            $document = MlstEmployeeDocuments::create($input['documentData']);
            $last3 = MlstEmployeeDocuments::latest('id')->first();
            $result = ['success' => true, 'result' => $document, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = MlstEmployeeDocuments::where(['document_name' => $request['document_name']])
                ->where('id', '!=', $id)
                ->get()
                ->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errorMsg' => 'Document name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['documentData'] = array_merge($request, $create);
            $result = MlstEmployeeDocuments::where('id', $id)->update($input['documentData']);
            $result = ['success' => true, 'result' => $input['documentData']];
            return json_encode($result);
        }
    }

}
