<?php
namespace App\Http\Controllers\frontend;

use App\Models\frontend\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\CareerManagement\Models\WebCareers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Modules\CareerManagement\Models\WebCareersApplications;
use App\Modules\Projects\Models\MlstBmsbProjectStatus;
use App\Modules\Projects\Models\MlstBmsbProjectType;
use App\Classes\S3;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectBlocks;
use App\Models\backend\Employee;
use App\Modules\Testimonials\Models\WebTestimonials;
use App\Modules\Projects\Models\MlstBmsbAmenities;
use App\Modules\WebPages\Models\WebPage;
use App\Models\WebThemes;
use App\Modules\BlogManagement\Models\WebBlogs;
use App\Modules\News\Models\WebNews;
use App\Modules\PressRelease\Models\WebPressRelease;
use App\Modules\Events\Models\WebEvents;
use Config;
use DB;
use App\Classes\CommonFunctions;
use App\Models\MlstState;
use App\Models\MlstCountry;
use App\Models\MlstCity;
use App\Models\MlstTitle;
use App\Modules\ContactUs\Models\WebContactus;
use App\Models\Contactus;
use Illuminate\Support\Facades\Route;

class UserController extends Controller {

    public $themeName = '';

    public function __construct() {
        try {
            $id = Route::current()->getParameter('id');

            if (!empty($id)) {
                $result = WebThemes::where('id', $id)->select(['id', 'theme_name'])->first();

                session(['previewTheme' => $result['theme_name']]);
                $this->themeName = session('previewTheme');
            }
            if (session('previewTheme') != '') {
                Config::set('global.themeName', session('previewTheme'));
                $this->themeName = session('previewTheme');
            } else {
                $result = WebThemes::where('status', '1')->select(['id', 'theme_name'])->first();
                Config::set('global.themeName', $result['theme_name']);
                $this->themeName = $result['theme_name'];
            }
        } catch (\Exception $ex) {
            return \View::make('layouts.backend.error500')->withSuccess('Page not found');
        }
    }

    public function load() {
        return view('website');
    }

    public function getMenus() {
        $getProjects = WebPage::with(['menuList'])->where('status', '=', '1')->where('page_type', '=', '0')->orderBy('parent_page_position')->get();
        return json_encode(['result' => $getProjects, 'status' => true]);
    }

    public function onPageReload($param) {
        return \Redirect::to("http://" . $_SERVER["HTTP_HOST"] . "/#/" . $param);
    }

    public function index() {
        $testimonials = WebTestimonials::where(['web_status' => '1', 'approve_status' => '1'])->get();
        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                        ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
                        ->select(["db2.first_name", "db2.personal_email1", "db2.last_name", "db2.id", "db1.designation"])
                        ->orderByRaw("RAND()")->get();
        $images = WebPage::where('page_name', 'index')->select('banner_images')->first();
        $currentResult = [];
        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list', 'project_web_pages.short_description')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
                ->get();
        for ($i = 0; $i < count($current); $i++) {
            $aminity = explode(',', $current[$i]['project_amenities_list']);
            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->select('name_of_amenity')->get();
            $result = ['id' => $current[$i]['id'], 'project_name' => $current[$i]['project_name'], 'project_logo' => $current[$i]['project_logo'], 'amenities' => $aminities];
            array_push($currentResult, $result);
        }
        return view('frontend.' . $this->themeName . '.index')->with(["testimonials" => $testimonials, 'employee' => $employees, 'background' => $images, 'current' => $currentResult]);
    }

    public function career() {
        $result = WebCareers::all();
        return view('frontend.' . $this->themeName . '.careers')->with("carrier", $result);
    }

    public function testimonialdetail($id) {
        return view('frontend.' . $this->themeName . '.testimonial-detail')->with("Id", $id);
    }

    public function getTestimonialDetails() {
        $input = Input::all();
        $result = WebTestimonials::where('testimonial_id', '=', $input['testimonial_id'])->first();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function testimonials() {
        $testimonials = WebTestimonials::where(['web_status' => '1', 'approve_status' => '1'])->get();
        return view('frontend.' . $this->themeName . '.testimonials')->with(["testimonials" => $testimonials]);
    }

    public function getfCountries() {
        $getCountires = MlstCountry::all();
        if (!empty($getCountires)) {
            $result = ['success' => true, 'records' => $getCountires];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function updateEmployee() {

        $request = Input::all();
        $id = $request['data']['id'];
        $userdata = $request['data'];

        if ($userdata['marital_status'] == 2 && !empty($userdata['marriage_date'])) {
            $userdata['marriage_date'] = date('Y-m-d', strtotime($userdata['marriage_date']));
        }

        if (!empty($userdata['date_of_birth'])) {
            $userdata['date_of_birth'] = date('Y-m-d', strtotime($userdata['date_of_birth']));
        }

        if ($userdata['employee_photo_is_available'] == 1) {
            $imageName = time() . "_" . rand(10, 10000) . "." . $userdata['employee_photo_file_name']->getClientOriginalExtension();
            $tempPath = $userdata['employee_photo_file_name']->getPathName();
            $folderName = 'Employee-Photos';
            $name = S3::s3FileUpload($tempPath, $imageName, $folderName);
            $userdata['employee_photo_file_name'] = $name;
        } else {
            $userdata['employee_photo_file_name'] = "";
        }
        unset($userdata['employee_photo_is_available']);
        $update = CommonFunctions::updateMainTableRecords(0);
        $userdata = array_merge($userdata, $update);
        $employeeupdate = Employee::where('id', $id)->update($userdata);

        if (!empty($employeeupdate)) {
            $employee = Employee::where("id", $id)->first();
            $password = substr(rand(10000000, 99999999), 0, 8);
            $username = $employee->username;
            $employee->password = \Hash::make($password);
            $employee->high_security_password_type = 1;
            $employee->high_security_password = 1234;

            if ($employee->save()) {

                $templatedata['employee_id'] = $employee->id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 0;
                $templatedata['template_setting_employee'] = 26;
                $templatedata['customer_id'] = 0;
                $templatedata['arrExtra'][0] = array(
                    '[#username#]',
                    '[#password#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $username,
                    $password
                );

                $url = "website/thanking-you";
                $result = CommonFunctions::templateData($templatedata);
                $result = ['success' => true, 'url' => $url];
            } else {
                $result = ['success' => false];
            }
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function addContact() {
        header('Access-Control-Allow-Origin: *');
        $input = Input::all();
        $name = explode(' ', $input['contactData']['name']);
        $input['contactData']['first_name'] = $name[0];
        if (!empty($name[1])) {
            $input['contactData']['last_name'] = $name[1];
        }
        $result = Contactus::create($input['contactData']);
        if ($result) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['result' => '']);
        }
    }

    public function getfCities() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request['data']['stateId'])) {
            $stateId = $request['data']['stateId'];
            $getCities = MlstCity::select('id', 'state_id', 'name')->where("state_id", $stateId)->get();
            if (!empty($getCities)) {
                $result = ['success' => true, 'records' => $getCities];
                return json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
                return json_encode($result);
            }
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
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

    public function registration($id) {
        $employeeid = base64_decode($id);
        
        $employee = Employee::where("id", $employeeid)->first();
       
        if (!empty($employee->password) || empty($employee)) {
            return view("frontend.common.linkexpired")->with("empId", $employeeid);
        } else {
            $client = json_decode(config('global.client_info'), true);
            $client_id = $client['master_client_id'];
            $clientinfo = \App\Models\ClientInfo::where('id', $client_id)->first();
            if (!empty($clientinfo->company_logo)) {
                $company_logo = $clientinfo->company_logo;
            } else {
                $company_logo = '';
            }
            $clientdata['logo'] = config('global.s3Path') . '/client/' . $client_id . '/' . $company_logo;

            $clientdata['empId'] = $employeeid;
            return view("frontend.common.registration")->with("clientdata", $clientdata);
        }
    }

    public function create_testimonials() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $input = Input::all();
        if (!empty($input['photoUrl'])) {
            $originalName = $input['photoUrl']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {

                $s3FolderName = "Testimonials";
                $imageName = 'testimonial_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['photoUrl']->getClientOriginalExtension();
                S3::s3FileUpload($input['photoUrl']->getPathName(), $imageName, $s3FolderName);
                $photo_url = $imageName;
            } else {
                $photo_url = '';
            }
        }       
        if (!empty($input['testimonial'])) {
            $input['testimonial']['photo_url'] = $photo_url;
            $result = WebTestimonials::create($input['testimonial']);
        } else {
            $input['photo_url'] = $photo_url;
            $result = WebTestimonials::create($input);
        }        
        /* mail/message template for testimonials */
        
        $templatedata['employee_id'] = 1;
        $templatedata['client_id'] = config('global.client_id');
        $comp = config('global.companyName');
        $templatedata['template_setting_customer'] = 54;
        $templatedata['template_setting_employee'] = 53;
        $templatedata['customer_id'] = 0;
        $templatedata['project_id'] = 0;
        $templatedata['frontuserEmailId'] = $input['email_id'];
        $templatedata['frontuserMobile'] = $input['mobile_number'];
        $templatedata['arrExtra'][0] = array(
                    '[#testCustName#]',
                    '[#testCustMob#]',
                    '[#experience#]',
                    '[#companyMktName#]',
                );
                $templatedata['arrExtra'][1] = array(
                    $input['customer_name'],
                    $input['mobile_number'],
                    $input['description'],
                    $comp,
                );
        $result = CommonFunctions::templateData($templatedata);        
        /* end mail/message template for testimonials */        
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getCareers() {
        $result = WebCareers::where('deleted_status', 0)->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function contact() {
        return view('frontend.' . $this->themeName . '.contact');
    }

    public function about() {
        $about = WebPage::where('page_name', 'about')->select('page_content', 'banner_images')->first();
        return view('frontend.' . $this->themeName . '.about')->with("about", $about);
    }

    public function getContactDetails() {
        $contacts = WebContactus::all();
        if (!empty($contacts)) {
            return json_encode(['result' => $contacts, 'status' => true]);
        } else {
            return json_encode(['records' => "No record found", 'status' => false]);
        }
    }

    public function register_applicant() {
        $input = Input::all();
        if (!empty($input['resumeFileName'])) {
            $originalName = $input['resumeFileName']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $s3FolderName = "career/resume";
                $imageName = 'resume_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['resumeFileName']->getClientOriginalExtension();
                S3::s3FileUpload($input['resumeFileName']->getPathName(), $imageName, $s3FolderName);
                $resume_file_name = $imageName;
                unset($input['resumeFileName']);
            } else {
                unset($input['resumeFileName']);
                $resume_file_name = '';
            }
        }
        if (!empty($input['photoUrl'])) {

            $originalName = $input['photoUrl']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {

                $s3FolderName = "career/applicants";
                $imageName = 'applicant_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['photoUrl']->getClientOriginalExtension();
                S3::s3FileUpload($input['photoUrl']->getPathName(), $imageName, $s3FolderName);
                $photo_url = $imageName;
                unset($input['photoUrl']);
            }
        } else {
            unset($input['photoUrl']);
            $photo_url = '';
        }
        $post = ['first_name' => $input['career']['first_name'],
            'last_name' => $input['career']['last_name'],
            'mobile_number' => $input['career']['mobile_number'],
            'email_id' => $input['career']['email_id'],
            'career_id' => $input['career']['career_id'],
            'resume_file_name' => $resume_file_name,
            'photo_url' => $photo_url,
        ];
        $result = WebCareersApplications::create($post);
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['records' => "Failed to add record", 'status' => false]);
        }
    }

    public function getBackGroundImages() {
        $images = WebPage::where('page_name', 'index')->select('banner_images')->first();
        return json_encode(['result' => $images, 'status' => true]);
    }

    public function getAboutPageContent() {
        $about = WebPage::where('page_name', 'about')->select('page_content', 'banner_images')->first();
        return json_encode(['result' => $about, 'status' => true]);
    }

    public function jobPost() {
        $result = WebCareers::all();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['records' => "No record found", 'status' => false]);
        }
    }

    public function getEmployees() {

        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                        ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
                        ->select(["db2.first_name", "db2.employee_photo_file_name", "db2.personal_email1", "db2.last_name", "db2.id", "db1.designation"])
                        ->orderByRaw("RAND()")->get();

        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function projects() {
        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
                ->get();
        $Upcoming = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Upcoming')
                ->get();
        $Completed = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Completed')
                ->get();
        return view('frontend.' . $this->themeName . '.projects')->with(["current" => $current, "upcoming" => $Upcoming, "completed" => $Completed]);
    }

    public function getProjectsAllProjects() {
        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list', 'project_web_pages.short_description')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
                ->get();
        $Upcoming = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.short_description')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Upcoming')
                ->get();
        $Completed = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.short_description')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Completed')
                ->get();
        return json_encode(["current" => $current, "upcoming" => $Upcoming, "completed" => $Completed, 'status' => true]);
    }

    public function projectdetails($projectId) {

        $bannerImg = DB::table('project_web_pages')->select('project_banner_images')->where('project_id', '=', $projectId)->first();
        return view('frontend.' . $this->themeName . '.projectdetails')->with(["projectId" => $projectId, "bannerImg" => $bannerImg->project_banner_images]);
    }

    public function getProjectDetails() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $projects = Project::join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->get();
        $availble = Project::join('project_blocks', 'project_blocks.project_id', '=', 'projects.id')
                ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as mlst_bmsb_block_types', 'mlst_bmsb_block_types.id', '=', 'project_blocks.block_type_id')
                ->select('mlst_bmsb_block_types.block_name', 'mlst_bmsb_block_types.id', 'project_blocks.project_id')->groupBy('mlst_bmsb_block_types.block_name')
                ->get();
        $getProjects = Project::join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                        ->where('projects.id', $request['id'])->first();
        if (!empty($getProjects->project_amenities_list)) {
            $aminity = explode(',', $getProjects->project_amenities_list);
            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->get();
        } else {
            $aminities = [];
        }
        return json_encode(['result' => $getProjects, 'projects' => $projects, 'availble' => $availble, 'aminities' => $aminities, 'status' => true]);
    }

    public function getAvailbility() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = ProjectBlocks::where('block_type_id', '=', $request['block_id'])->where('project_id', '=', $request['project_id'])->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getEmployee() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $id = $request['data']['empId'];
        $employee = Employee::where("id", $id)->select('*')->first();
        if (!empty($employee)) {
            $result = ['success' => true, "records" => $employee];
            echo json_encode($result);
        } else {
            $result = ['success' => false];
        }
    }

    public function getfStates() {
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

    public function getBlogs() {
        $blog = WebBlogs::where('blog_status', '=', '1')->get();
        if (!empty($blog)) {
            $result = ['status' => true, 'records' => $blog];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function blog() {
        return view('frontend.' . $this->themeName . '.blogs');
    }

    public function blogdetails($blog_id) {
        return view('frontend.' . $this->themeName . '.blog-details')->with('blog_id', $blog_id);
    }

    public function getBlogDetails() {
        $input = Input::all();
        $result = WebBlogs::where('id', '=', $input['blog_id'])->first();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getTestimonials() {
        $result = WebTestimonials::where('deleted_status', 0)->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function news() {
        return view('frontend.' . $this->themeName . '.news');
    }

    public function getNews() {
        $result = WebNews::all();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function newsdetails($news_id) {
        return view('frontend.' . $this->themeName . '.news-details')->with('news_id', $news_id);
    }

    public function getNewsDetails() {
        $input = Input::all();
        $result = WebNews::where('id', '=', $input['news_id'])->first();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function press_release() {
        return view('frontend.' . $this->themeName . '.press-release');
    }

    public function getpressRelease() {
        $result = WebPressRelease::all();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function press_release_details($id) {
        return view('frontend.' . $this->themeName . '.press-release-details')->with('Id', $id);
    }

    public function getpressReleaseDetails() {
        $input = Input::all();
        $result = WebPressRelease::where('id', '=', $input['id'])->first();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function events() {
        return view('frontend.' . $this->themeName . '.events');
    }

    public function getEvents() {
        $result = WebEvents::where('status', '=', '1')->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function eventDetails($id) {
        return view('frontend.' . $this->themeName . '.event-details')->with('Id', $id);
    }

    public function getEventDetails() {
        $input = Input::all();
        $result = WebEvents::where('id', '=', $input['id'])->first();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getCurrentProjectDetails() {
        $currentResult = [];
        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list', 'project_web_pages.short_description')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
                ->get();

        for ($i = 0; $i < count($current); $i++) {
            $aminity = explode(',', $current[$i]['project_amenities_list']);
            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->select('name_of_amenity')->get();
            $result = ['id' => $current[$i]['id'], 'project_name' => $current[$i]['project_name'], 'project_logo' => $current[$i]['project_logo'], 'short_description' => $current[$i]['short_description'], 'amenities' => $aminities];
            array_push($currentResult, $result);
        }
        return json_encode(['current' => $currentResult, 'status' => true]);
    }

    public function enquiry() {
        return view('frontend.' . $this->themeName . '.enquiry');
    }

    public function getThankingYou() {
        return view("frontend.common.thanking-you");
    }

}
