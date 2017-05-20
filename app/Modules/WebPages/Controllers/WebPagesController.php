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
        $input = Input::all();
        
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUplod($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

                $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['contentData']['banner_images'] = $name;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['contentData'] = array_merge($input['contentData'], $update);
        $updatedata = WebPage::where('id', $input['pageId'])->update($input['contentData']);
        echo json_encode(['success' => true, 'records' => $updatedata, 'message' => 'page updated successfully']);
    }
    
    public function storeSubWebPage()
    {
        $input = Input::all();
      
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUplod($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

                $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['subcontentPage']['banner_images'] = $name;
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['page_type'] = '1';
        $last = WebPage::where('page_type', '1')->orderBy('id', 'desc')->first();
        if(!empty($last->child_page_id))
        { $input['subcontentPage']['child_page_id'] = $last->child_page_id+1; }else{ $input['subcontentPage']['child_page_id'] = '1';  }   
        $update = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['subcontentPage'] = array_merge($input['subcontentPage'], $update);
        
        $insertdata = WebPage::create($input['subcontentPage']);
        $latest = WebPage::latest('id')->first();
        echo json_encode(['success' => true, 'records' => $input['subcontentPage'],'id'=>$latest->id, 'message' => 'page updated successfully']);
    }
    
    
    
    
    public function updateSubWebPage()
    {
        $input = Input::all();
       
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUplod($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

                $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['subcontentPage']['banner_images'] = $name;
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['page_type'] = '1';
        $last = WebPage::where('page_type', '1')->orderBy('id', 'desc')->first();
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['subcontentPage'] = array_merge($input['subcontentPage'], $update);
        unset($input['subcontentPage']['id']);
        
        $updatedata = WebPage::where('id','=',$input['id'])->update($input['subcontentPage']);
        echo json_encode(['success' => true, 'records' => $input['subcontentPage'], 'message' => 'page updated successfully']);
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
    public function getSubPages() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $getSubPages = WebPage::where('parent_id', $obj['Data']['pageId'])->get();
        if ($getSubPages) {
            $result = ['success' => true, 'records' => $getSubPages];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPageImage() {
        $input = Input::all();

        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
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
        $path = $s3FolderName . $obj['imageName'];
        $msg = S3::s3FileDelete($path);
        if ($msg) {
            $updatedata = WebPage::where('id', $obj['pageId'])->update(['banner_images' => $name]);
        } else {
            
        }
    }
    
      public function removeSubWebPageImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['subimgs']);
        $s3FolderName = '/website/banner-images/';
        $path = $s3FolderName . $obj['imageName'];
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
