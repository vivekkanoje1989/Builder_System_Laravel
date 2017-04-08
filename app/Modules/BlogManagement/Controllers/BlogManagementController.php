<?php

namespace App\Modules\BlogManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\BlogManagement\Models\WebBlogs;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Classes\CommonFunctions;
use Auth;
use App\Classes\S3;

class BlogManagementController extends Controller {

    public function index() {
        return view("BlogManagement::index");
    }
    public function manageBlogs() {
        $getBlogs = WebBlogs::all();
        if (!empty($getBlogs)) {
            $result = ['success' => true, 'records' => $getBlogs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createBlogs() {
        return view("BlogManagement::create");
    }

    public function edit($id) {
        return view("BlogManagement::update")->with("id", $id);
    }

    public function getBlogsDetail() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getBlogs = WebBlogs::where('id', $request['blog_id'])->first();
        if (!empty($getBlogs)) {
            $result = ['success' => true, 'records' => $getBlogs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function store() {
        $input = Input::all();
        if (!empty($input['blogImages']['blog_banner_images'])) {

            $originalName = $input['blogImages']['blog_banner_images']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['blogImages']['blog_banner_images']->getClientOriginalExtension();
                $image = ['0' => $input['blogImages']['blog_banner_images']];
                $s3FolderName = $input['foldername'];
                $fileName = S3::s3FileUplod($image, $s3FolderName, 1);
                $banner_images = trim($fileName, ",");
            } else {
                unset($input['blog_banner_images']);
                $banner_images = '';
            }
        }

        if (!empty($input['galleryImage']['galleryImage'])) {
            $imgCount = count($input['galleryImage']['galleryImage']);
            if ($imgCount > 0) {

                $s3FolderName = 'galleryImages';
                $fileName = S3::s3FileUplod($input['galleryImage']['galleryImage'], $s3FolderName, $imgCount);
                $allfile = trim($fileName, ",");
            }
        } else {
            $allfile = '';
            unset($input['blog_images']);
        }
        $cnt = WebBlogs::where(['blog_title' => $input['blog_title']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['blogData'] = array_merge($input, $create);
            $input['blogData']['blog_code'] = date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . rand('1', '10000');
            $input['blogData']['blog_banner_images'] = $banner_images;
            $input['blogData']['blog_images'] = $allfile;
            $blogData = WebBlogs::create($input['blogData']);
            $result = ['success' => true, 'result' => $blogData];
            return json_encode($result);
        }
    }

    public function update($id) {
        $input = Input::all();
        if (!empty($input['blogImages']['blog_banner_images'])) {

            $originalName = $input['blogImages']['blog_banner_images']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['blogImages']['blog_banner_images']->getClientOriginalExtension();
                $image = ['0' => $input['blogImages']['blog_banner_images']];
                $s3FolderName = 'blogBannerImages';
                $fileName = S3::s3FileUplod($image, $s3FolderName, 1);
                $banner_images = trim($fileName, ",");
            } else {
                unset($input['blog_banner_images']);
                $banner_images = $input['allbanner'];
            }
        }
        if (!empty($input['galleryImage']['galleryImage'])) {
            $imgCount = count($input['galleryImage']['galleryImage']);
            if ($imgCount > 0) {

                $s3FolderName = 'galleryImages';
                $fileName = S3::s3FileUplod($input['galleryImage']['galleryImage'], $s3FolderName, $imgCount);
                $allfile = trim($fileName, ",");
                $allfile .= ",";
                $allfile .= implode(',', $input['allgallery']);
            }
        } else {
            $allfile = '';
            unset($input['blog_images']);
            $allfile = implode(',', $input['allgallery']);
        }


        $cnt = WebBlogs::where(['blog_title' => $input['blog_title']])
                        ->where('id', '!=', $id)->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['blogData'] = array_merge($input, $create);
            $input['blogData']['blog_banner_images'] = $banner_images;
            $input['blogData']['blog_images'] = $allfile;
            unset($input['blogData']['blogImages']);
            unset($input['blogData']['galleryImage']);
            unset($input['blogData']['allgallery']);
            unset($input['blogData']['allbanner']);
            $blogData = WebBlogs::where('id', '=', $id)->update($input['blogData']);
            $result = ['success' => true, 'result' => $blogData];
            return json_encode($result);
        }
    }

    public function removeBlogImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['allimg']);
        $s3FolderName = 'Blog';
        $msg = S3::s3FileDelete($obj['imageName'], $s3FolderName);

        if ($msg) {
            $updatedata = WebBlogs::where('id', $obj['blogId'])->update(['blog_images' => $name]);
        } else {
            
        }
    }

}
