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

class ManageDepartmentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageDepartment::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageDepartment() {
        $getDepartment = MlstBmsbDepartment::leftJoin('mlst_bmsb_verticals', 'mlst_bmsb_departments.vertical_id', '=', 'mlst_bmsb_verticals.id')->select('mlst_bmsb_departments.id', 'name', 'department_name', 'vertical_id')->get();
        // print_r($getDepartment); exit;
//        $getDepartment = DB::table('users')
//            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
//            ->get();
        if (!empty($getDepartment)) {
            $result = ['success' => true, 'records' => $getDepartment];
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
        //$request = json_decode($postdata, true);
        $request = Input::all();
       // print_r($request);
      //  exit;
        $getCount = MlstBmsbDepartment::where(['department_name' => $request['department_name'], ['id', '<>', $id]])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $result = MlstBmsbDepartment::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
