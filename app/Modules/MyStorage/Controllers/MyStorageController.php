<?php

namespace App\Modules\MyStorage\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\S3;
use Illuminate\Support\Facades\Input;
use App\Modules\MyStorage\Models\MyStorage;
use Auth;
use DB;

class MyStorageController extends Controller {

    public function index() {
        return view("MyStorage::index");
    }

    public function allFiles($filename) {
        return view("MyStorage::allimages")->with("filename", $filename);
    }

    public function sharedWithMe() {
        return view("MyStorage::sharedwithme");
    }

    public function recycleBin() {
        return view("MyStorage::recyclebin");
    }

    public function store() {
        try {
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
            $result = S3::s3CreateDirectory($request['filename']);
            $dbresult = MyStorage::create(['folder' => $request['filename']]);
            $result = ["status" => true, 'result' => $result];
            return json_encode($result);
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }

    public function sharedWith() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = MyStorage::where('folder', $request['folder'])->first();
        $share_with = $result['share_with'] . ',' . $request['share_with'];
        $post = ['share_with' => $share_with];
        $update = MyStorage::where('folder', $request['folder'])->update($post);
        return json_encode(['result' => $update, 'status' => true]);
    }

    public function getEmployees() {

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
                ->select(["db2.first_name", "db2.last_name", "db2.id", "db1.designation"])
                ->where('db2.id', '!=', $loggedInUserId)
                ->get();
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getStorage() {
        $res = S3::s3DirectoryLists();
        return json_encode(['result' => $res, 'status' => true]);
    }

    public function getMyStorage() {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        //$query = MyStorage::whereRaw('FIND_IN_SET($loggedInUserId,share_with)')->get();

        $query = MyStorage::whereRaw(
                        'find_in_set(?, share_with)', $loggedInUserId)->get();
        if (!empty($query)) {
            $result = ['status' => true, 'records' => $query];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function deleteFolder() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = S3::s3FolderDelete($request['foldername']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function allFolderImages() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = S3::s3FileLists($request['filename']);
        print_r($result);
    }

    public function subFolder() {
        $input = Input::all();

        if (!empty($input['fileName']['fileName'])) {

            $originalName = $input['fileName']['fileName']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['fileName']['fileName']->getClientOriginalExtension();
                $image = ['0' => $input['fileName']['fileName']];
                $s3FolderName = $input['foldername'];
                $fileName = S3::s3FileUplod($image, $s3FolderName, 1);
                $banner_images = trim($fileName, ",");
                return json_encode(['result' => $input['foldername'] . '/' . $banner_images, 'status' => true]);
            } else {
                unset($input['blog_banner_images']);
                $banner_images = '';
                return json_encode(['errorMsg' => 'No Image selected', 'status' => false]);
            }
        }
    }

    public function deleteImages() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = S3::s3FileDelete($request['filepath']);
        return json_encode(['result' => $result, 'status' => true]);
    }

}
