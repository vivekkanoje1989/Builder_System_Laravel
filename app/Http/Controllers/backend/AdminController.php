<?php

namespace App\Http\Controllers\backend;

use Auth;
use App\Http\Controllers\Controller;
use App\Classes\MenuItems;
use App\Models\backend\Employee;
use App\Models\MlstTitle;
use App\Models\MlstGender;
use App\Models\MlstBloodGroup;
use App\Models\MlstDepartment;
use App\Models\MlstEducation;
use App\Models\MlstCountry;
use App\Models\MlstState;
use App\Models\MlstCity;
use App\Models\ClientInfo;
use App\Models\EnquirySource;
use App\Models\EnquirySubSource;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\MlstProfession;
use Illuminate\Http\Request;
use App\Classes\Gupshup;
use App\Modules\PropertyPortals\Models\PropertyPortalsType;
use App\Modules\WebPages\Models\WebPage;

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
        
        /*$rootPath = config('global.rootPath'); 
        $data = ["filePath" => $rootPath."/bulkMobileNumbers1.xls","fileName" => "bulkMobileNumbers1.xls", "sendingType" => 1, "textSmsBody" => "send msg in bulk", "smsType" => "bulk_sms"];
        $result = Gupshup::sendBulkSMS($data);
        $decodeResult = json_decode($result,true);
        return $decodeResult["message"];*/
        
        /*$smsBody = "Hello bms";
        $mobileNo = 917709026395;//9970844335;
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $customer = "No";
        $customerId = 1;
        $isInternational = 0; //0 OR 1
        $sendingType = 1; //always 0 for T_SMS
        $smsType = "T_SMS";
        $result = Gupshup::sendSMS($smsBody, $mobileNo, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
        $decodeResult = json_decode($result,true);
        return $decodeResult["message"];
        echo "<pre>";print_r($decodeResult);exit;*/
        
//        $rows = DB::select('CALL sp_test(1)');
//        return json_encode($id);
//        if(Auth::guard('admin')->check()){ 
//            echo "login".Auth::guard('admin')->user()->id;            
//        }else {echo "not login";}
//        echo "<pre>";print_r(Auth::guard('admin')->user());exit;
        $fullName = Auth::guard('admin')->user()->first_name . " " . Auth::guard('admin')->user()->last_name;
        return view('layouts.backend.dashboard')->with('id', $fullName);
    }

    public function getMenuItems() {
        $permission = json_decode(Auth()->guard('admin')->user()->employee_submenus,true);
        $getMenu = MenuItems::getMenuItems();
        $menuItem = $accessToActions = array();
        foreach ($getMenu as $key => $menu) {
            $menu = (array) $menu;
            if (!empty($menu['url'])) {
                $accessToActions[] = $menu['url'];
            }
            $submenu_ids = explode(',', $menu['submenu_ids']);
            
            if ($menu['has_submenu'] == 1) {
                $intersection_arr = array_intersect($permission, $submenu_ids);//child1 id
                if (empty($intersection_arr)) {
                    continue;
                }
                if (isset($menu['submenu'])) {                    
                    foreach ($menu['submenu'] as $k => $submenu) {
                        $submenu = (array) $submenu;
                        if (!empty($submenu['url'])) {
                            $accessToActions[] = $submenu['url'];
                        }
                        if (!(in_array($submenu['id'], $intersection_arr))) {
                            unset($menu['submenu'][$k]);
                        }
                        if (!empty($submenu['submenu'])) {
                            $submenu_ids2 = explode(',', $submenu['submenu_ids']);
                            $intersection_arr2 = array_intersect($permission, $submenu_ids2);//child2 id
                            foreach ($submenu['submenu'] as $k2 => $submenu2) {
                                $submenu2 = (array) $submenu2;
                                if (!(in_array($submenu2['id'], $intersection_arr2)) && !empty($menu['submenu'][$k])) {
                                    unset($menu['submenu'][$k]['submenu'][$k2]);
                                }
                                
                                if (!empty($submenu2['submenu'])) {
                                    $submenu_ids3 = explode(',', $submenu2['submenu_ids']);
                                    $intersection_arr3 = array_intersect($permission, $submenu_ids3);//child3 id
                                    foreach ($submenu2['submenu'] as $k3 => $submenu3) {
                                        $submenu3 = (array) $submenu3;
                                        if (!(in_array($submenu3['id'], $intersection_arr3)) && !empty($menu['submenu'][$k]['submenu'][$k2])) {
                                            unset($menu['submenu'][$k]['submenu'][$k2]['submenu'][$k3]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $menuItem[] = $menu;
        }
        $collection = collect(['mainMenu' => $menuItem]);
        $merged = $collection->merge(['actions' => $accessToActions]);
        $mergedMmenu = $merged->all();
        return json_encode($mergedMmenu);
        exit;
    }
    
    public function getTitle() {
        $getTitle = MlstTitle::all();
        if (!empty($getTitle)) {
            $result = ['success' => true, 'records' => $getTitle];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getGender() {
        $getGender = MlstGender::all();
        if (!empty($getGender)) {
            $result = ['success' => true, 'records' => $getGender];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getBloodGroup() {
        $getBloodGroup = MlstBloodGroup::all();
        if (!empty($getBloodGroup)) {
            $result = ['success' => true, 'records' => $getBloodGroup];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getDepartments() {
        $getDepartments = MlstDepartment::all();
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEducationList() {
        $getEducationList = MlstEducation::all();
        if (!empty($getEducationList)) {
            $result = ['success' => true, 'records' => $getEducationList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getProfessionList() {
        $getProfessionList = MlstProfession::all();
        if (!empty($getProfessionList)) {
            $result = ['success' => true, 'records' => $getProfessionList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getMasterData() {
        $getTitle = MlstTitle::all();
        $getGender = MlstGender::all();
        $getBloodGroup = MlstBloodGroup::all();
        $getDepartments = MlstDepartment::all();
        $getEducationList = MlstEducation::all();
        $getEnquirySource = EnquirySource::all();
        $getEnquirySubSource = EnquirySubSource::all();
        $getEmployees = Employee::select('id', 'first_name')->get();
        if (!empty($getTitle)) {
            $result = ['success' => true, 'title' => $getTitle, 'gender' => $getGender, 'bloodGroup' => $getBloodGroup, 'departments' => $getDepartments, 'educationList' => $getEducationList, 'employees' => $getEmployees, 'getEnquirySource' => $getEnquirySource, 'getEnquirySubSource' => $getEnquirySubSource];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getCountries() {
        $getCountires = MlstCountry::all();
        if (!empty($getCountires)) {
            $result = ['success' => true, 'records' => $getCountires];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getStates(Request $request) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $countryId = $request['data']['countryId'];
        $getStates = MlstState::where("country_id", $countryId)->get();
        if (!empty($getStates)) {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getCities() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $stateId = $request['data']['stateId'];
        $getCities = MlstCity::where("state_id", $stateId)->get();
        if (!empty($getCities)) {
            $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
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

    public function getEnquirySource() {
        $getSource = EnquirySource::all();
        if (!empty($getSource)) {
            $result = ['success' => true, 'records' => $getSource];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEnquirySubSource() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $sourceId = $request['data']['sourceId'];
        $getsubSource = EnquirySubSource::where('source_id', $sourceId)->get();
        if (!empty($getsubSource)) {
            $result = ['success' => true, 'records' => $getsubSource];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getTeamLead() {
        $getTeamLead = Employee::all();
        if (!empty($getTeamLead)) {
            $result = ['success' => true, 'records' => $getTeamLead];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    /****************************UMA************************************/
    public function getWebPageList() {
        $getpages = WebPage::all();
        if (!empty($getpages)) {
            $result = ['success' => true, 'records' => $getpages];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getPropertyPortalType() {
        $getPropertyPortal = PropertyPortalsType::all();
        if (!empty($getPropertyPortal)) {
            $result = ['success' => true, 'records' => $getPropertyPortal];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

   /****************************UMA************************************/
    /***************************MANDAR*********************************/

    public function getEmployees() {
        $getEmployees = Employee::select('id', 'first_name','last_name','designation')->where("client_id", 1)->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getClient() {
        $getclient = ClientInfo::all();
        if (!empty($getclient)) {
            $result = ['success' => true, 'records' => $getclient];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getVehiclebrands() {
        $getVehiclebrands = VehicleBrand::all();
        if (!empty($getVehiclebrands)) {
            $result = ['success' => true, 'records' => $getVehiclebrands];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getVehiclemodels() {
        $getVehiclemodels = VehicleModel::select('*')->where("brand_id", 1)->get();
        if (!empty($getVehiclemodels)) {
            $result = ['success' => true, 'records' => $getVehiclemodels];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    /***************************MANDAR*********************************/
    
    protected function guard() {
        return Auth::guard('admin');
    }
}
