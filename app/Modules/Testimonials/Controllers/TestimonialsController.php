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

    public function manage() {
        return view("Testimonials::manage");
    }

    public function create() {
        return view("Testimonials::create");
    }

    public function manageEdit($id) {
        return view("Testimonials::manageUpdate")->with("testimonialId", $id);
    }

    public function getApproveTestimonials() {
        $getApprovedTestimonials = WebTestimonials::all();
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getTestimonialData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getTestimonials = WebTestimonials::where('testimonial_id', $request['testimonial_id'])->first();

        if (!empty($getTestimonials)) {
            $result = ['success' => true, 'records' => $getTestimonials];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageApprovedTestimonials() {
        $getApprovedTestimonials = WebTestimonials::where('approve_status', '1')->get();
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $input = Input::all();
        
        $s3FolderName = 'Testimonial';
        
        $image = ['0' => $input['photo_url']['photo_url']];
        $fileName = S3::s3FileUplod($image, $s3FolderName, 1);
        $fileName = trim($fileName, ",");
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['testimonialsData'] = array_merge($input, $create);
        $input['testimonialsData']['photo_url'] = $fileName;
        $result = WebTestimonials::create($input['testimonialsData']);
        return json_encode($result);
    }

    public function edit($id) {
        return view("Testimonials::update")->with("testimonialId", $id);
    }

    public function update() {
        $input = Input::all();
        if (!empty($input['photo_url']['photo_url'])) {

            $originalName = $input['photo_url']['photo_url']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['photo_url']['photo_url']->getClientOriginalExtension();
                $image = ['0' => $input['photo_url']['photo_url']];
                $s3FolderName = 'Testimonial';
                $fileName = S3::s3FileUplod($image, $s3FolderName, 1);
                $fileName = trim($fileName, ",");
                $input['photo_url'] = $fileName;
            } else {
                unset($input['photo_url']);
            }
        }

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['testimonialsData'] = array_merge($input, $create);
        $result = WebTestimonials::where('testimonial_id', $input['testimonial_id'])->update($input['testimonialsData']);
        return json_encode($result);
    }

}
