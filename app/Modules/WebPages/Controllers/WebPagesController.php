<?php

namespace App\Modules\WebPages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\WebPages\Models\WebPage;
use Validator;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;
use Auth;

class WebPagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("WebPages::index");
    }

    public function getWebPages() {
        $data = WebPage::all();
        if ($data) {
            $result = ['success' => true, 'records' => ["data" => $data, "total" => count($data), 'per_page' => count($data),
                    "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($data)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function create() {
        //
    }

    public function store() {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        return view("WebPages::updateWebPage")->with("pageId", $id);
    }

    public function getEditWebPage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $alldata = WebPage::where('id', $obj['Data']['pageId'])->get();
        if ($alldata) {
            $result = ['success' => true, 'records' => $alldata];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        //print_r($obj['contentData']);exit;
        $validationMessages = WebPage::validationMessages();
        $validationRules = WebPage::validationRules();
        if (!empty($obj['contentData'])) {
            $validator = Validator::make($obj['contentData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result, true);
                exit;
            }
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $obj['contentData'] = array_merge($obj['contentData'], $update);
        $updatedata = WebPage::where('id', $obj['pageId'])->update($obj['contentData']);
        $result = ['success' => true, 'message' => 'page updated successfully'];
        echo json_encode($result);
    }

    public function getImages() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $getImages = WebPage::where('id', $obj['Data']['pageId'])->select('banner_images')->get();
        if ($getImages) {
            $result = ['success' => true, 'records' => $getImages];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPageImage() {
        $input = Input::all();
       // print_r($input['pageId']);        
        //print_r($random);
      //  exit;
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] .'_'. rand(pow(10, config('global.randomNoDigits')-1), pow(10, config('global.randomNoDigits'))-1).'.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUplod($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);
            $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $updatedata = WebPage::where('id', $input['pageId'])->update(['banner_images' => $name]);
        $result = ['success' => true, 'message' => 'Image updated successfully'];
        echo json_encode($result);
    }

    public function removeWebPageImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['allimg']);
        $s3FolderName = '/website/banner-images/';
        $path =$s3FolderName.$obj['imageName'];
        $msg = S3::s3FileDelete($path);
        if ($msg) {
            $updatedata = WebPage::where('id', $obj['pageId'])->update(['banner_images' => $name]);
        } else {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
