<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Classes\MenuItems;
use App\Models\backend\Employee;
use App\Models\LstTitle;
use App\Models\LstGender;
use App\Models\LstBloodGroup;
use App\Models\LstDepartment;
use App\Models\LstEducation;
use App\Models\LstCountry;
use App\Models\LstState;
use App\Models\LstCity;
use App\Models\ClientInfo;
use App\Models\EnquirySource;
use App\Models\EnquirySubSource;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\LstProfession;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    public function dashboard() {

//        $rows = DB::select('CALL sp_test(1)');
//        return json_encode($id);
//        if(Auth::guard('admin')->check()){ 
//            echo "login".Auth::guard('admin')->user()->id;            
//        }else {echo "not login";}
//        echo "<pre>";print_r(Auth::guard('admin')->user());exit;
        $fullName = Auth::guard('admin')->user()->first_name." ".Auth::guard('admin')->user()->last_name;  
        return view('layouts.backend.dashboard')->with('id', $fullName);
    }
    
    public function getMenuItems() {
        $permission = json_decode(Auth()->guard('admin')->user()->employee_submenus);
        $getMenu = MenuItems::getMenuItems();
        $menuItem = $accessToActions =array();
        foreach ($getMenu as $key => $menu) {
            $menu = (array) $menu;
            if(!empty($menu['url'])){
                $accessToActions[] = $menu['url'];
            }            
            $submenu_ids = explode(',', $menu['submenu_ids']);
            if ($menu['has_submenu'] == 1) {
                $intersection_arr = array_intersect($permission, $submenu_ids);
                if (empty($intersection_arr)){
                    continue;
                }
                if (isset($menu['submenu'])) {
                    foreach ($menu['submenu'] as $k => $submenu) {
                        $submenu = (array) $submenu;
                        if(!empty($submenu['url'])){
                            $accessToActions[] = $submenu['url'];
                        }
                        if (!(in_array($submenu['id'], $intersection_arr))) {
                            unset($menu['submenu'][$k]);
                        }
                    }
                }
            }
            $menuItem[] = $menu;
        }
        $collection = collect(['mainMenu'=>$menuItem]);
        $merged = $collection->merge(['actions'=>$accessToActions]);
        $mergedMmenu = $merged->all();
        return json_encode($mergedMmenu);
        exit;
    }
    
    public function getTitle(){
        $getTitle = LstTitle::all();
        if(!empty($getTitle))
        {
            $result = ['success' => true, 'records' => $getTitle];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getGender(){
        $getGender = LstGender::all();
        if(!empty($getGender))
        {
            $result = ['success' => true, 'records' => $getGender];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getBloodGroup(){
        $getBloodGroup = LstBloodGroup::all();
        if(!empty($getBloodGroup))
        {
            $result = ['success' => true, 'records' => $getBloodGroup];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getDepartments(){
        $getDepartments = LstDepartment::all();
        if(!empty($getDepartments))
        {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getEducationList(){
        $getEducationList = LstEducation::all();
        if(!empty($getEducationList))
        {
            $result = ['success' => true, 'records' => $getEducationList];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getProfessionList(){
        $getProfessionList = LstProfession::all();
        if(!empty($getProfessionList))
        {
            $result = ['success' => true, 'records' => $getProfessionList];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getMasterData(){
        $getTitle = LstTitle::all();
        $getGender = LstGender::all();
        $getBloodGroup = LstBloodGroup::all();
        $getDepartments = LstDepartment::all();
        $getEducationList = LstEducation::all();
        if (!empty($getTitle)) {
            $result = ['success' => true, 'title' => $getTitle, 'gender' => $getGender,'bloodGroup' => $getBloodGroup,'departments' =>$getDepartments,'educationList' => $getEducationList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getCountries(){
        $getCountires = LstCountry::all();
        if(!empty($getCountires))
        {
            $result = ['success' => true, 'records' => $getCountires];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getStates(Request $request){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $countryId = $request['data']['countryId'];
        $getStates = LstState::where("country_id",$countryId)->get();
        if(!empty($getStates))
        {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getCities(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $stateId = $request['data']['stateId'];
        $getCities = LstCity::where("state_id",$stateId)->get();
        if(!empty($getCities))
        {
            $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function checkUniqueEmail() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $id = $request['data']['id'];
        if ($id == 0) {
            $checkEmail = Employee::getRecords(["email"], ["email" => $request['data']['emailData']]);
        } else {
            $checkEmail = Employee::select('email')->where([
                        ['email', '=', $request['data']['emailData']],
                        ['id', '<>', $id],
                    ])->get();
            $checkEmail = json_decode($checkEmail);
        }
        if (empty($checkEmail[0]->email)) {
            $result = ['success' => true];
            return json_encode($result);
        } else {
            $result = ['success' => false];
            return json_encode($result);
        }
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    
    /****************************MANDAR*********************************/
    
    public function getEmployees(){
        $getEmployees = Employee::select('id','first_name')->where("client_id",1)->get();
        if(!empty($getEmployees))
        {
            $result = ['success' => true, 'records' => $getEmployees];
            return $result;
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getClient(){
        $getclient = ClientInfo::all();
        if(!empty($getclient))
        {
            $result = ['success' => true, 'records' => $getclient];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getEnquirysources(){
        $getEnquirysources = EnquirySource::select('*')->where("client_id",1)->get();
        if(!empty($getEnquirysources))
        {
            $result = ['success' => true, 'records' => $getEnquirysources];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getEnquirysubsources(){
        $getEnquirysubsources = EnquirySubSource::select('*')->where("client_id",1)->get();
        if(!empty($getEnquirysubsources))
        {
            $result = ['success' => true, 'records' => $getEnquirysubsources];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getVehiclebrands(){
        $getVehiclebrands = VehicleBrand::all();
        if(!empty($getVehiclebrands))
        {
            $result = ['success' => true, 'records' => $getVehiclebrands];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getVehiclemodels(){
        $getVehiclemodels = VehicleModel::select('*')->where("brand_id",1)->get();
        if(!empty($getVehiclemodels))
        {
            $result = ['success' => true, 'records' => $getVehiclemodels];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    /****************************MANDAR*********************************/
}
