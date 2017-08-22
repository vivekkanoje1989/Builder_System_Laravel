<?php

namespace App\Modules\EmployeeDocuments\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\EmployeeDocuments\Models\MlstEmployeeDocuments;
use Illuminate\Http\Request;
use Auth;
use App\Classes\CommonFunctions;

class EmployeeDocumentsController extends Controller {

    public function index() {
        return view("EmployeeDocuments::index");
    }

    public function employeeDocuments() {
        $result = MlstEmployeeDocuments::all();
        if (!empty($result)) {
            $result = ['success' => true, 'records' => $result];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
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
