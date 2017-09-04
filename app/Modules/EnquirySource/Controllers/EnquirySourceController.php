<?php

namespace App\Modules\EnquirySource\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\EnquirySource\Models\MlstBmsbEnquirySalesSources;
use App\Modules\EnquirySource\Models\EnquirySalesSubSources;
use App\Classes\CommonFunctions;



class EnquirySourceController extends Controller {

    public function index() {
        return view("EnquirySource::index");
    }

    public function manageEnquirySource() {
        $getEnquirySources = MlstBmsbEnquirySalesSources::all();
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
          
        $getSubEnquirySources = EnquirySalesSubSources::where(['enquiry_sales_source_id' => $request['source_id']])->get();
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

        $cnt = MlstBmsbEnquirySalesSources::where(['source_name' => $request['source_name']])->get()->count();
        if ($cnt > 0) { //exists Source
            $result = ['success' => false, 'errormsg' => 'Source name already exists'];
            return json_encode($result);
        } else {
            $bloodgroup = MlstBmsbEnquirySalesSources::create($request);
            $result = ['success' => true, 'result' => $bloodgroup];
            return json_encode($result);
        }
    }

    
    public function createsubEnquirySource()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = EnquirySalesSubSources::where(['sub_source' => $request['sub_source']])->get()->count();
        if ($cnt > 0) { //exists Source
            $result = ['success' => false, 'errormsg' => 'Sub source name already exists'];
            return json_encode($result);
        } else {
            $result = EnquirySalesSubSources::create($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    public function updateSubEnquirySource() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = EnquirySalesSubSources::where(['sub_source' => $request['sub_source']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Sub source name already exists'];
            return json_encode($result);
        } else {
            $result = EnquirySalesSubSources::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
