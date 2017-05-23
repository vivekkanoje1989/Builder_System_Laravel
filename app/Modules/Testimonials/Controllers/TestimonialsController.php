<?php

namespace App\Modules\Testimonials\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Modules\Testimonials\Models\WebTestimonials;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;
use Auth;

class TestimonialsController extends Controller {

    public function index() {
        return view("Testimonials::index");
    }

    public function show() {
        return view("Testimonials::manage");
    }
    
    public function create() {
        return view("Testimonials::create");
    }

    public function editApproved($id) {
        return view("Testimonials::editApprovedList")->with("testimonialId", $id);
    }

    public function getDisapproveList() {
        $getApprovedTestimonials = WebTestimonials::where('approve_status', '0')->get();
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
    public function getApprovedList() {
        $getApprovedTestimonials = WebTestimonials::where('approve_status', '1')->get();
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getTestimonialData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getTestimonials = WebTestimonials::where('testimonial_id', $request['testimonial_id'])->first();

        if (!empty($getTestimonials)) {
            $result = ['success' => true, 'records' => $getTestimonials];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function store() {
        $input = Input::all();
        $s3FolderName = '/Testimonial/';
        $fileName = 'testimonial_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['photo_url']->getClientOriginalExtension();
        S3::s3FileUplod($input['photo_url']->getPathName(), $fileName, $s3FolderName);
        
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        
        $input['testimonialsData'] = array_merge($input, $create);
        $input['testimonialsData']['photo_url'] = $fileName;
        $insertData = WebTestimonials::create($input['testimonialsData']);
        if($insertData){
            $result = ['success' => true, "records" => $insertData];
        }
        else{
            $result = ['success' => true, "records" => "Something went wrong"];
        }
        return json_encode($result);
    }

    public function edit($id) {
        return view("Testimonials::update")->with("testimonialId", $id);
    }

    public function update($id) {
        $input = Input::all();
        if (is_object($input['photo_url'])) {
            $originalName = $input['photo_url']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['photo_url']->getClientOriginalExtension();
                $s3FolderName = '/Testimonial/';
                $getOldPhoto = WebTestimonials::select('photo_url')->where('testimonial_id', $id)->get();               
                $path = $s3FolderName . $getOldPhoto[0]['photo_url'];
                S3::s3FileDelete($path);                                            
                $imageName = "testimonial_".rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $fileName;
                S3::s3FileUplod($input['photo_url']->getPathName(), $imageName, $s3FolderName);
                $fileName = trim($imageName, ",");
                $input['photo_url'] = $fileName;
            } else {
                unset($input['photo_url']);
            }
        }
        unset($input['_method']);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['testimonialsData'] = array_merge($input, $update);
        $updateTestimonials = WebTestimonials::where('testimonial_id', $input['testimonial_id'])->update($input['testimonialsData']);
        $result = ['success' => true, "records" => $updateTestimonials];
        echo json_encode($result);
    }

}
