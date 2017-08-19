<?php
namespace App\Modules\ManageDepartment\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartment;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Modules\ManageDepartment\Models\MlstBmsbVerticals;

class ManageDepartmentController extends Controller {
  
    public function index() {
        return view("ManageDepartment::index");
    }

    public function manageDepartment() {
        $getDepartments = MlstBmsbDepartment::with(['vertical'])->select('department_name','id','vertical_id')->get();
       // $getDepartment = MlstBmsbDepartment::leftJoin('laravel_developement_master_edynamics.mlst_bmsb_verticals as mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        $i=0;
        foreach($getDepartments as $getDepartment){
            $getDepartments[$i]['verticalData'] = $getDepartment['vertical']['name'];
            $i++;
        }
        
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getDepartment() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getDepartment = MlstBmsbDepartment::leftJoin('mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->where('mlst_bmsb_departments.id', $request['id'])->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbDepartment::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['departmentData'] = array_merge($request, $create);
            $result = MlstBmsbDepartment::create($input['departmentData']);
            $last3 = MlstBmsbDepartment::latest('id')->first();
            $input['departmentData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
    
        $getCount = MlstBmsbDepartment::where(['department_name' => $request['department_name'], ['id', '!=', $id]])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $result = MlstBmsbDepartment::where('id', $id)->update($request);
            $vertical = MlstBmsbVerticals::where('id','=',$request['vertical_id'])->first();
            $result = ['success' => true, 'result' => $result,'vertical'=>$vertical];
            return json_encode($result);
        }
    }

}
