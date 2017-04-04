<?php

namespace App\Modules\EnquirySource\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\EnquirySource\Models\EnquirySources;
use App\Modules\EnquirySource\Models\EnquirySubSources;
use App\Classes\CommonFunctions;


class EnquirySourceController extends Controller {

    public function index() {
        return view("EnquirySource::index");
    }

    public function manageEnquirySource() {
        $getEnquirySources = EnquirySources::all();
        if (!empty($getEnquirySources)) {
            $result = ['success' => true, 'records' => $getEnquirySources];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function manageSubEnquirySource(){
         $postdata = file_get_contents('php://input');
         $request = json_decode($postdata, true);
          
        $getSubEnquirySources = EnquirySubSources::where(['source_id' => $request['source_id']])->get();
        if (!empty($getSubEnquirySources)) {
            $result = ['success' => true, 'records' => $getSubEnquirySources];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = EnquirySources::where(['source_name' => $request['source_name']])->get()->count();
        if ($cnt > 0) { //exists Source
            $result = ['success' => false, 'errormsg' => 'Source name already exists'];
            return json_encode($result);
        } else {
            $bloodgroup = EnquirySources::create($request);
            $result = ['success' => true, 'result' => $bloodgroup];
            return json_encode($result);
        }
    }

    
    public function createsubEnquirySource()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = EnquirySubSources::where(['sub_source' => $request['sub_source']])->get()->count();
        if ($cnt > 0) { //exists Source
            $result = ['success' => false, 'errormsg' => 'Sub source name already exists'];
            return json_encode($result);
        } else {
            $result = EnquirySubSources::create($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    public function updateSubEnquirySource() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = EnquirySubSources::where(['sub_source' => $request['sub_source']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Sub source name already exists'];
            return json_encode($result);
        } else {
            $result = EnquirySubSources::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
