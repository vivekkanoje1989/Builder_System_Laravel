<?php

namespace App\Http\Controllers\backend;

use Auth;
use App\Http\Controllers\Controller;
use App\Classes\MenuItems;
use App\Models\backend\Employee;
use App\Models\MlstTitle;
use App\Models\MlstGender;
use App\Models\MlstBloodGroup;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartment;
use App\Models\MlstEducation;
use App\Models\MlstCountry;
use App\Models\MlstState;
use App\Models\MlstCity;
use App\Modules\ManageCity\Models\MlstCities;
use App\Models\ClientInfo;
use App\Models\MlstBmsbEnquirySalesSource;
use App\Models\EnquirySalesSubSource;
use App\Models\MlstEnquirySalesChannel;
use App\Models\MlstProfession;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\MlstBmsbVertical;
use App\Models\MlstBmsbDesignation;
use App\Models\LstEnquiryLocation;
use App\Models\MlstBmsbBlockType;
use App\Models\ProjectBlock;
use App\Models\Project;
use App\Models\Company;
use App\Models\CompanyStationary;
use App\Models\MlstEnquirySalesCategory;
use App\Models\EnquirySalesSubcategory;
use App\Models\MlstEnquirySalesStatus;
use App\Models\EnquirySalesSubstatus;
use App\Models\MlstBmsbAmenity;
use Illuminate\Http\Request;
use App\Classes\Gupshup;
use App\Modules\PropertyPortals\Models\MlstBmsbPropertyPortal;
use App\Modules\WebPages\Models\WebPage;
use App\Modules\MasterSales\Models\EnquiryFinanceTieup;
use App\Modules\EnquiryLocations\Models\lstEnquiryLocations;
use App\Models\SystemConfig;
use App\Classes\S3;
use App\Classes\CommonFunctions;
use App\Modules\BlockStages\Models\LstDlBlockStages;

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
        /* $rootPath = config('global.rootPath'); 
          $data = ["filePath" => $rootPath."/bulkMobileNumbers1.xls","fileName" => "bulkMobileNumbers1.xls", "sendingType" => 1, "textSmsBody" => "send msg in bulk", "smsType" => "bulk_sms"];
          $result = Gupshup::sendBulkSMS($data);
          $decodeResult = json_decode($result,true);
          return $decodeResult["message"]; */

        /* $smsBody = "Hello bms";
          $mobileNo = 917709026395;//9970844335;
          $loggedInUserId = Auth::guard('admin')->user()->id;
          $customer = "No";
          $customerId = 1;
          $isInternational = 0; //0 OR 1
          $sendingType = 0; //always 0 for T_SMS
          $smsType = "T_SMS";
          $result = Gupshup::sendSMS($smsBody, $mobileNo, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
          $decodeResult = json_decode($result,true);

          return $decodeResult["message"];
          echo "<pre>";print_r($decodeResult);exit; */

//        $rows = DB::select('CALL sp_test(1)');
//        return json_encode($id);
//        if(Auth::guard('admin')->check()){ 
//            echo "login".Auth::guard('admin')->user()->id;            
//        }else {echo "not login";}
//        echo "<pre>";print_r(Auth::guard('admin')->user());exit;
        $fullName = Auth::guard('admin')->user()->first_name . " " . Auth::guard('admin')->user()->last_name;
        return view('layouts.backend.dashboard')->with('id', $fullName);
    }

    public function sessiontimeout() {
        return view('backend.sessiontimeout');
    }

    public function getMenuItems() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request['data']['loggedInUserId'])) { //for mobile app
            $employeeSubmenus = Employee::select("employee_submenus")->where("id", json_decode($request['data']['loggedInUserId']))->get();
            $permission = json_decode($employeeSubmenus[0]->employee_submenus, true);
        } else {//for web app
            $permission = json_decode(Auth()->guard('admin')->user()->employee_submenus, true);
//            $session = SystemConfig::where('id',Auth()->guard('admin')->user()->id)->get(); 
//            session(['submenus' => Auth()->guard('admin')->user()->employee_submenus]); 
//            session(['s3Path' => 'https://s3.'.$session[0]->region.'.amazonaws.com/'.$session[0]->aws_bucket_id.'/']); 
        }
        $getMenu = MenuItems::getMenuItems();
        $menuItem = $accessToActions = array();
        foreach ($getMenu as $key => $menu) {
            $menu = (array) $menu;
            if (!empty($menu['url'])) {
                $accessToActions[] = $menu['url'];
            }
            $submenu_ids = explode(',', $menu['submenu_ids']);

            if ($menu['has_submenu'] == 1) {
                $intersection_arr = array_intersect($permission, $submenu_ids); //child1 id
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
                            $intersection_arr2 = array_intersect($permission, $submenu_ids2); //child2 id
                            foreach ($submenu['submenu'] as $k2 => $submenu2) {
                                $submenu2 = (array) $submenu2;
                                if (!(in_array($submenu2['id'], $intersection_arr2)) && !empty($menu['submenu'][$k])) {
                                    unset($menu['submenu'][$k]['submenu'][$k2]);
                                }

                                if (!empty($submenu2['submenu'])) {
                                    $submenu_ids3 = explode(',', $submenu2['submenu_ids']);
                                    $intersection_arr3 = array_intersect($permission, $submenu_ids3); //child3 id
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
    }

    public function getTitle() {
        $getTitle = MlstTitle::where("status", 1)->get();
        if (!empty($getTitle)) {
            $result = ['success' => true, 'records' => $getTitle];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getGender() {
        $getGender = MlstGender::where("status", 1)->get();
        if (!empty($getGender)) {
            $result = ['success' => true, 'records' => $getGender];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function checkUniqueEmployeeId() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($request['data']['employee_id'] != '') {
            $id = $request['data']['id'];
            $employee_id = $request['data']['employee_id'];

            if ($id == 0) {
                $checkEmployee = Employee::select('employee_id')
                        ->where('employee_id', "$employee_id")
                        ->first();
            } else {
                $checkEmployee = Employee::select('employee_id')
                                ->where([
                                    ['employee_id', '=', "$employee_id"],
                                    ['id', '<>', $id],
                                ])->first();
            }

            if (empty($checkEmployee)) {
                $result = ['success' => true];
            } else {
                $result = ['success' => false];
            }
        } else {
            $result = ['success' => true];
        }
        return json_encode($result);
    }

    public function getBloodGroup() {
        $getBloodGroup = MlstBloodGroup::all();
        if (!empty($getBloodGroup)) {
            $result = ['success' => true, 'records' => $getBloodGroup];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getDesignations() {
        $getBloodGroup = MlstBmsbDesignation::where("status", 1)->get();
        if (!empty($getBloodGroup)) {
            $result = ['success' => true, 'records' => $getBloodGroup];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getDepartments() {
        $getDepartments = MlstBmsbDepartment::all();
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getEducationList() {
        $getEducationList = MlstEducation::where("status", 1)->get();
        if (!empty($getEducationList)) {
            $result = ['success' => true, 'records' => $getEducationList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getProfessionList() {
        $getProfessionList = MlstProfession::all();
        if (!empty($getProfessionList)) {
            $result = ['success' => true, 'records' => $getProfessionList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getBlockTypes() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $blockList = ProjectBlock::select('id', 'block_type_id', 'block_sub_type')->where('project_id', $request['projectId'])->get();

        $getBlockTypeId = array();
        if (!empty($blockList)) {
            foreach ($blockList as $key => $value) {
                $getBlockTypeId[] = $value['block_type_id'];
            }
        }
        $blockTypeId = implode(",", $getBlockTypeId);
        $blockTypeList = MlstBmsbBlockType::select('id', 'block_name')->whereIn('id', $getBlockTypeId)->get();

        if (!empty($blockTypeList)) {
            $result = ['success' => true, 'records' => $blockTypeList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getSubBlocks() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $subBlocksList = ProjectBlock::select("id", "block_sub_type")->whereIn("block_type_id", json_decode($request['data']['myJsonString']))->get();
        if (!empty($subBlocksList)) {
            $result = ['success' => true, 'records' => $subBlocksList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getMasterData() {
        $getTitle = MlstTitle::where("status", 1)->get();
        $getGender = MlstGender::where("status", 1)->get();
        $getBloodGroup = MlstBloodGroup::all();
        $getDepartments = MlstBmsbDepartment::all();
        $getEducationList = MlstEducation::where("status", 1)->get();
        $getEnquirySource = MlstBmsbEnquirySalesSource::where("status", 1)->get();
        $getEnquirySubSource = EnquirySalesSubSource::where("sub_source_status", 1)->get();
        $getMlstProfession = MlstProfession::where("status", 1)->get();
        $getMlstBmsbDesignation = MlstBmsbDesignation::where("status", 1)->get();
        $getStates = MlstState::where('country_id', 101)->get();
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'department_id','employee_id')->where("employee_status", 1)->get();
        $blockTypeList = MlstBmsbBlockType::select("id", "project_type_id", "block_name")->get();
        $projectList = Project::select('id', 'project_name')->get();
        $subBlocksList = ProjectBlock::select("id", "project_id", "block_type_id", "block_sub_type")->get();
        $enquiryFinanceTieup = EnquiryFinanceTieup::where("status", 1)->get();
        $salesEnqCategoryList = MlstEnquirySalesCategory::select('id', 'enquiry_category')->where("status", 1)->get();
        $salesEnqSubCategoryList = EnquirySalesSubcategory::select('id', 'enquiry_sales_subcategory', 'enquiry_sales_category_id')->where("status", 1)->get();
        $salesEnqStatusList = MlstEnquirySalesStatus::select('id', 'sales_status')->where("status", 1)->get();
        $salesEnqSubStatusList = EnquirySalesSubstatus::select('id', 'enquiry_sales_substatus', 'enquiry_sales_status_id')->where("status", 1)->get();
        $getEnquiryLocation = MlstCities::rightJoin('laravel_developement_builder_client.lst_enquiry_locations', 'mlst_cities.id', '=', 'laravel_developement_builder_client.lst_enquiry_locations.city_id')->where('laravel_developement_builder_client.lst_enquiry_locations.country_id', '=', 101)->get();
        $channelList = MlstEnquirySalesChannel::select('id', 'channel_name')->get();
        if (!empty($getTitle)) {
            $result = ['success' => true, 'title' => $getTitle, 'gender' => $getGender, 'bloodGroup' => $getBloodGroup, 'departments' => $getDepartments,
                'educationList' => $getEducationList, 'employees' => $getEmployees, 'getEnquirySource' => $getEnquirySource, 'getEnquirySubSource' => $getEnquirySubSource,
                'getMlstProfession' => $getMlstProfession, 'getMlstBmsbDesignation' => $getMlstBmsbDesignation, 'states' => $getStates,
                "blocks" => $blockTypeList, "projects" => $projectList, 'subblocks' => $subBlocksList, 'agencyList' => $enquiryFinanceTieup,
                'enquiryLocation' => $getEnquiryLocation, 'salesEnqCategoryList' => $salesEnqCategoryList, 'salesEnqSubCategoryList' => $salesEnqSubCategoryList,
                'salesEnqStatusList' => $salesEnqStatusList, 'salesEnqSubStatusList' => $salesEnqSubStatusList, 'channelList' => $channelList];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getCountries() {
        $getCountires = MlstCountry::all();
        if (!empty($getCountires)) {
            $result = ['success' => true, 'records' => $getCountires];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getStates(Request $request) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $countryId = $request['data']['countryId'];
        $getStates = MlstState::where("country_id", $countryId)->get();
        if (!empty($getStates)) {
            $result = ['success' => true, 'records' => $getStates];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getCities() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $stateId = $request['data']['stateId'];
        $getCities = MlstCity::where("state_id", $stateId)->get();
        if (!empty($getCities)) {
            $result = ['success' => true, 'records' => $getCities];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getLocations() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $countryId = $request['data']['countryId'];
        $stateId = $request['data']['stateId'];
        $cityId = $request['data']['cityId'];
        $getLocations = LstEnquiryLocation::where(['country_id' => $countryId, 'state_id' => $stateId, 'city_id' => $cityId])->get();
        if (!empty($getLocations)) {
            $result = ['success' => true, 'records' => $getLocations];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function checkUniqueEmail() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $id = $request['data']['id'];
        if ($id == 0) {
            $checkEmail = Employee::getRecords(["personal_email1"], ["personal_email1" => $request['data']['emailData']]);
        } else {
            $checkEmail = Employee::select('personal_email1')->where([
                        ['personal_email1', '=', $request['data']['emailData']],
                        ['id', '<>', $id],
                    ])->get();
            $checkEmail = json_decode($checkEmail);
        }
        if (empty($checkEmail[0]->personal_email1)) {
            $result = ['success' => true];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function checkUniqueMobile() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $id = $request['data']['id'];
        $mobileData = $request['data']['mobileData'];

        if ($id == 0) {
            $checkMobile = Employee::select('personal_mobile1', 'office_mobile_no')
                    ->where('personal_mobile1', $mobileData)
                    ->orWhere('office_mobile_no', $mobileData)
                    ->first();
        } else {
            $checkMobile = Employee::select('personal_mobile1', 'office_mobile_no')
                    ->where(function($query) use ($mobileData) {
                        $query->where('personal_mobile1', $mobileData)
                        ->orWhere('office_mobile_no', $mobileData);
                    })
                    ->where('id', '<>', $id)
                    ->first();
        }

        if (empty($checkMobile)) {
            $result = ['success' => true];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function checkUniqueMobile1() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request['data']['mobileData'])) {
            $mobileData = $request['data']['mobileData'][0];
            $id = $request['data']['id'];
            if ($id == 0) {
                $checkMobile = Employee::select('personal_mobile1', 'office_mobile_no')
                        ->where('personal_mobile1', $mobileData)
                        ->orWhere('office_mobile_no', $mobileData)
                        ->first();
            } else {
                $checkMobile = Employee::select('personal_mobile1', 'office_mobile_no')
                        ->where(function($query) use ($mobileData) {
                            $query->where('personal_mobile1', $mobileData)
                            ->orWhere('office_mobile_no', $mobileData);
                        })
                        ->where('id', '<>', $id)
                        ->first();
            }
            if (empty($checkMobile)) {
                $result = ['success' => true];
            } else {
                $result = ['success' => false];
            }
            return json_encode($result);
        }
    }

    public function getTeamLead($id) {
        $designation = MlstBmsbDesignation::with('employeeName')->get();
        foreach ($designation as $desg) {
            if (!empty($desg['employeeName'])) {
                $employee[] = ['id' => $desg['employeeName']['id'], 'first_name' => $desg['employeeName']['first_name'], 'last_name' => $desg['employeeName']['last_name'], 'designation_name' => $desg['designation']];
            }
        }
        if (!empty($employee)) {
            $result = ['success' => true, 'records' => $employee];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageBlockStages() {
        $getBlockstage = LstDlBlockStages::all();
        if (!empty($getBlockstage)) {
            $result = ['success' => true, 'records' => $getBlockstage, 'totalCount' => count($getBlockstage)];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function editDepartments() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $getDepartmentsFromEmployee = Employee::select('department_id')->where('id', $request['data'])->get();
        $explodeDepartment = explode(",", $getDepartmentsFromEmployee[0]->department_id);
        $getDepartments = MlstBmsbDepartment::whereNotIn('id', $explodeDepartment)->get();
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEnquirySource() {
        $getSource = MlstBmsbEnquirySalesSource::where("status", 1)->get();
        if (!empty($getSource)) {
            $result = ['success' => true, 'records' => $getSource];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getEnquirySubSource() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $sourceId = $request['data']['sourceId'];
        $getsubSource = EnquirySalesSubSource::select("id", "enquiry_sales_source_id", "sub_source", "sub_source_status")->where(['enquiry_sales_source_id' => $sourceId, 'sub_source_status' => 1])->get();
        if (!empty($getsubSource)) {
            $result = ['success' => true, 'records' => $getsubSource];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getProjects() {
        $projectList = Project::select('id', 'project_name')->get();
        if (!empty($projectList)) {
            $result = ['success' => true, 'records' => $projectList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getCompany() {
        $companyList = Company::select('id', 'legal_name')->get();
        if (!empty($companyList)) {
            $result = ['success' => true, 'records' => $companyList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getStationary() {
        $stationaryList = CompanyStationary::select('id', 'stationary_set_name')->where("status", 1)->get();
        if (!empty($stationaryList)) {
            $result = ['success' => true, 'records' => $stationaryList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getSalesEnqCategory() {
        $salesEnqCategoryList = MlstEnquirySalesCategory::select('id', 'enquiry_category')->where("status", 1)->get();
        if (!empty($salesEnqCategoryList)) {
            $result = ['success' => true, 'records' => $salesEnqCategoryList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getSalesEnqSubCategory() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $categoryId = $request['categoryId'];

        $salesEnqSubCategoryList = EnquirySalesSubcategory::where(['enquiry_sales_category_id' => $categoryId, 'status' => 1])->select('id', 'enquiry_sales_subcategory')->get();
        if (!empty($salesEnqSubCategoryList)) {
            $result = ['success' => true, 'records' => $salesEnqSubCategoryList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getSalesEnqStatus() {
        $salesEnqStatusList = MlstEnquirySalesStatus::select('id', 'sales_status')->where("status", 1)->get();
        if (!empty($salesEnqStatusList)) {
            $result = ['success' => true, 'records' => $salesEnqStatusList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getSalesEnqSubStatus() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $statusId = $request['statusId'];

        $salesEnqSubStatusList = EnquirySalesSubstatus::where(['enquiry_sales_status_id' => $statusId, 'status' => 1])->select('id', 'enquiry_sales_substatus')->get();
        if (!empty($salesEnqSubStatusList)) {
            $result = ['success' => true, 'records' => $salesEnqSubStatusList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getAmenitiesList() {
        $amenitiesList = MlstBmsbAmenity::select('id', 'name_of_amenity')->where("amenity_status", 1)->get();
        if (!empty($amenitiesList)) {
            $result = ['success' => true, 'records' => $amenitiesList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getChannelList() {
        $channelList = MlstEnquirySalesChannel::select('id', 'channel_name')->get();
        if (!empty($channelList)) {
            $result = ['success' => true, 'records' => $channelList];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    /*     * **************************UMA*********************************** */

    public function getWebPageList() {
        $getpages = WebPage::where("status", 1)->get();
        if (!empty($getpages)) {
            $result = ['success' => true, 'records' => $getpages];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getPropertyPortalType() {
        $getPropertyPortal = MlstBmsbPropertyPortal::where("status", 1)->get();
        if (!empty($getPropertyPortal)) {
            $result = ['success' => true, 'records' => $getPropertyPortal];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getVerticals() {
        $getVerticals = MlstBmsbVertical::all();
        if (!empty($getVerticals)) {
            $result = ['success' => true, 'records' => $getVerticals];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getFinanceTieupAgency() {
        $enquiryFinanceTieup = EnquiryFinanceTieup::where("status", 1)->get();
        if (!empty($enquiryFinanceTieup)) {
            $result = ['success' => true, 'records' => $enquiryFinanceTieup];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    /*     * **************************UMA*********************************** */
    /*     * *************************MANDAR******************************** */

    public function getEmployees() {
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id')->where("employee_status", 1)->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getClient() {
        $getclient = ClientInfo::all();
        if (!empty($getclient)) {
            $result = ['success' => true, 'records' => $getclient];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    public function getSalesSource() {
        $getSalesSource = MlstBmsbEnquirySalesSource::all();
        if (!empty($getSalesSource)) {
            $result = ['success' => true, 'records' => $getSalesSource];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
   /* public function getEnquirySubSource() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $sourceId = $request['data']['sourceId'];
        $getsubSource = EnquirySalesSubSource::where('enquiry_sales_source_id', $sourceId)->get();
       
        if (!empty($getsubSource) && count($getsubSource) > 0) {           
            $result = ['success' => true, 'records' => $getsubSource];
        } else {
            $result = ['success' => false, 'message' => 'No records found'];
        }
        return json_encode($result);
    }*/

    /*     * *************************MANDAR******************************** */
    /*     * *************************Rohit******************************** */

    public function checkOldPassword() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $id = Auth::guard('admin')->user()->id;
        $password = $request['data']['old_password'];
        $employee = Employee::select('password')->where('id', $id)->first();
        if (\Hash::check($password, $employee->password)) {
            $result = ['success' => true];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    /*     * *************************Rohit******************************** */

    protected function guard() {
        return Auth::guard('admin');
    }

}
