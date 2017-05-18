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
use App\Modules\DashBoard\Models\Employees;
use App\Modules\Testimonials\Models\WebTestimonials;
use App\Modules\Projects\Models\MlstBmsbAmenities;
use App\Modules\WebPages\Models\WebPage;
use App\Models\WebThemes;
use Config;
use DB;
use App\Modules\ContactUs\Models\WebContactus;

class UserController extends Controller {

    public $themeName;

    public function __construct() {
        $result = WebThemes::where('status', '1')->select(['id', 'theme_name'])->first();
        Config::set('global.themeName', $result['theme_name']);

        $this->themeName = Config::get('global.themeName');

        $getWebsiteUrl = config('global.getWebsiteUrl');
    }

    public function index() {
        $testimonials = WebTestimonials::all();
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
        return view('frontend.' . $this->themeName . '.career')->with("carrier", $result);
    }

    public function contact() {
        return view('frontend.' . $this->themeName . '.contact');
    }

    public function about() {
        $about = WebPage::where('page_name', 'About Us')->select('page_content', 'banner_images')->first();
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
                S3::s3FileUplod($input['resumeFileName']->getPathName(), $imageName, $s3FolderName);
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
                S3::s3FileUplod($input['photoUrl']->getPathName(), $imageName, $s3FolderName);
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
        $about = WebPage::where('page_name', 'About Us')->select('page_content', 'banner_images')->first();
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
                        ->select(["db2.first_name", "db2.personal_email1", "db2.last_name", "db2.id", "db1.designation"])
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
        return json_encode(["current" => $current, "upcoming" => $Upcoming, "completed" => $Completed, 'status' => true]);
    }

    public function projectdetails($projectId) {

        return view('frontend.' . $this->themeName . '.projectdetails')->with("projectId", $projectId);
    }

    public function getProjectDetails() {
        $input = Input::all();
        $projects = Project::join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->get();

        $availble = Project::join('project_blocks', 'project_blocks.project_id', '=', 'projects.id')
                ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as mlst_bmsb_block_types', 'mlst_bmsb_block_types.id', '=', 'project_blocks.block_type_id')
                ->select('mlst_bmsb_block_types.block_name', 'mlst_bmsb_block_types.id', 'project_blocks.project_id')->groupBy('mlst_bmsb_block_types.block_name')
                ->get();

        $getProjects = Project::join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                        ->where('projects.id', $input['id'])->first();
        if (!empty($getProjects->project_amenities_list)) {
            $aminity = explode(',', $getProjects->project_amenities_list);
            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->get();
        } else {
            $aminities = [];
        }
        return json_encode(['result' => $getProjects, 'projects' => $projects, 'availble' => $availble, 'aminities' => $aminities, 'status' => true]);
    }

    public function getAvailbility() {
        $input = Input::all();
        $result = ProjectBlocks::where('block_type_id', '=', $input['block_id'])->where('project_id', '=', $input['project_id'])->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function dashboard() {
        return view('frontend.dashboard');
    }

    public function getCurrentProjectDetails() {
        $currentResult = [];
        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list')
                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
                ->get();

        for ($i = 0; $i < count($current); $i++) {
            $aminity = explode(',', $current[$i]['project_amenities_list']);
            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->select('name_of_amenity')->get();
            $result = ['id' => $current[$i]['id'], 'project_name' => $current[$i]['project_name'], 'project_logo' => $current[$i]['project_logo'], 'amenities' => $aminities];
            array_push($currentResult, $result);
        }
        return json_encode(['current' => $currentResult, 'status' => true]);
    }

}
