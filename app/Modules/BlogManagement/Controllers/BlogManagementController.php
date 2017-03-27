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

     $imgCount =   count($input['galleryImage']['galleryImage']);
        
        $s3FolderName = "Blog_Banner";
        $fileName = S3::s3FileUplod($input['blogImages']['blog_banner_images'], $s3FolderName, 1);
        $fileName = trim($fileName, ",");

        
        $input = Input::all();
        $name = implode(",", $input['galleryImage']['galleryImage']);
        $s3FolderName ='Blog';  
        $fileone = '';
        $input['galleryImage']['galleryImage'];
                
        $fileone .= S3::s3FileUplod($input['galleryImage']['galleryImage'], $s3FolderName,$imgCount);
        $fileone .= trim($fileone, ",");
       
        $cnt = WebBlogs::where(['blog_title' => $input['blog_title']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['blogData'] = array_merge($input, $create);
            $input['blogData']['blog_code'] = date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . rand('1', '10000');
            $input['blogData']['blog_banner_images'] = $fileName;
            $input['blogData']['blog_images'] = $fileone;
            $blogData = WebBlogs::create($input['blogData']);
            $last3 = WebBlogs::latest('id')->first();
            $result = ['success' => true, 'result' => $blogData, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $input = Input::all();

        $s3FolderName = "Blog";
        $fileName = S3::s3FileUplod($input['blogImages']['blog_banner_images'][0], $s3FolderName, 1);
        $fileName = trim($fileName, ",");

        $cnt = WebBlogs::where(['blog_title' => $input['blog_title']])->get()->count();
        if ($cnt > 0) {  //exists blog_title
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {

            //$update = CommonFunctions::insertLogTableRecords();
            // $originalValues = WebBlogs::where('blog_id', $blog_id)->get();
            $result = WebBlogs::where('id', $id)->update($input);

            //$last = DB::table('blogs_logs')->latest('blog_id')->first();
            // $getResult = array_diff_assoc($originalValues[0]['attributes'], $input);
            //// $implodeArr = implode(",", array_keys($getResult));
            // $result = DB::table('blogs_logs')->where('blog_id', $last->blog_id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
    
    public function removeBlogImage()
    {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
       echo $obj;
        exit();
        $name = implode(',', $obj['allimg']);
        $s3FolderName = 'Blog';
        $msg = S3::s3FileDelete($obj['imageName'],$s3FolderName);
       
        if ($msg) {
            $updatedata = WebBlogs::where('id', $obj['blogId'])->update(['blog_images' => $name]);
          
        } else {
            
        }
    }

}
