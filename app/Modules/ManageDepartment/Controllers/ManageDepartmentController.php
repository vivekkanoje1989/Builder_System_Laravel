<?php
namespace App\Modules\ManageDepartment\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageDepartment\Models\MlstDepartments;
use DB;
use App\Classes\CommonFunctions;
use Auth;
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
        $getDepartment = MlstDepartments::leftJoin('mlst_verticals', 'mlst_departments.vertical_id', '=', 'mlst_verticals.id')->select('mlst_departments.id','name','department_name','vertical_id')->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstDepartments::where(['department_name' => $request['department_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Department already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;   
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['departmentData'] = array_merge($request, $create);
            $result = MlstDepartments::create($input['departmentData']);
            $last3 = MlstDepartments::latest('id')->first();
            $input['departmentData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        print_r($request);exit;
        $getCount = MlstDepartments::where(['department_name' => $request['department_name'],['id' ,'<>',$id]])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
            $result = MlstDepartments::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
           return json_encode($result);
        }
    }
}
