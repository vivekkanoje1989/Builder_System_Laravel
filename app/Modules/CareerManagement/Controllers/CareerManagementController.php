<?php

namespace App\Modules\CareerManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\CareerManagement\Models\WebCareers;
use App\Classes\CommonFunctions;
use Auth;
use App\Modules\CareerManagement\Models\WebCareersApplications;

class CareerManagementController extends Controller {

    public function index() {
        return view("CareerManagement::index");
    }

    public function create() {
        return view("CareerManagement::create");
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $careers = WebCareers::create($request);
        $last3 = WebCareers::latest('id')->first();
        $result = ['success' => true, 'result' => $careers, 'lastinsertid' => $last3->id];
        return json_encode($result);
    }

    public function manageCareers() {
        $careers = WebCareers::all();
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getCareer() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $careers = WebCareers::where('id', $request['id'])->first();
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function edit($id) {

        return view("CareerManagement::update")->with("id", $id);
    }

    public function deleteJob() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $careers = WebCareers::where('id', $request['id'])->delete();
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $careers = WebCareers::where('id', $id)->update($request);
        $result = ['success' => true, 'result' => $careers,];
        return json_encode($result);
    }

    public function show($id) {

        return view("CareerManagement::show")->with("career_id", $id);
    }

    public function viewapplicants() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $careers = WebCareersApplications::where('career_id', $request['career_id'])->get();
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function download($file_name) {
        $file_path = public_path('resumes/'.$file_name);
        return response()->download($file_path);
    }

}
