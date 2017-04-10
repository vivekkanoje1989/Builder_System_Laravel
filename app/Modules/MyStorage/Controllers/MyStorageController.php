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
use App\Classes\CommonFunctions;

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

    public function getAllListToRestore($filename) {
        return view("MyStorage::listtorestore")->with("filename", $filename);
    }

    public function allMyFiles($filename) {

        return view("MyStorage::allmyimages")->with("filename", $filename);
    }

    public function store() {
        try {
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
            $count = MyStorage::where('folder', $request['filename'])->get()->count();
            if ($count > 0) {
                $result = ['success' => false, 'errorMsg' => 'Folder already exists'];
                return json_encode($result);
            } else {
                $post = ['folder' => $request['filename']];
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['storeData'] = array_merge($post, $create);

                $result = S3::s3CreateDirectory($request['filename']);
                $dbresult = MyStorage::create($input['storeData']);
                $result = ["status" => true, 'result' => $dbresult];
                return json_encode($result);
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }

    public function sharedWith() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = MyStorage::where('folder', $request['folder'])->first();
        if ($request['share_with'] !== '') {
            $share_with = $result['share_with'] . ',' . $request['share_with'];
        } else {
            $share_with =  $request['share_with'];
        }
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
        $result = MyStorage::where('deleted_status', '0')->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getRecycleList() {
        $result = MyStorage::where('deleted_status', '1')->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getMyStorage() {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $query = MyStorage::whereRaw(
                        'find_in_set(?, share_with)', $loggedInUserId)->where('deleted_status', '0')->get();
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
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['folderData'] = array_merge($request, $create);
        $result = MyStorage::where('folder', $request['folder'])->update($input['folderData']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function restoreFolder() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['deleted_status'] = '0';
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['folderData'] = array_merge($request, $create);
        $result = MyStorage::where('folder', $request['folder'])->update($input['folderData']);

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

    public function folderSharedEmployees() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $result = MyStorage::where('folder', $request['folder'])->select('share_with')->first();
        print_r($result);
        exit();
        if (!empty($result->share_with)) {
            $employee_id = explode(',', $result->share_with);
            $employees = [];
            for ($i = 0; $i < count($employee_id); $i++) {
                $result = DB::table('employees')->where('id', $employee_id[$i])->select(['first_name', 'last_name'])->first();

                array_push($employees, ['first_name' => $result->first_name, 'last_name' => $result->last_name, 'employee_id' => $employee_id[$i]]);
            }
            return json_encode(['result' => $employees, 'status' => true]);
        } else {
            return json_encode(['errormsg' => 'Not shared yet', 'status' => true]);
        }
    }

    public function removeEmployees() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $result = MyStorage::where('folder', $request['folder'])->select('share_with')->first();
        if ($result->share_with) {
            $employee_id = explode(',', $result->share_with);
            $unique = array_unique($employee_id);
            $pos = array_search($request['employee_id'], $unique);
            unset($unique[$pos]);
            $share = implode(',', $unique);
            $post = ['share_with' => $share];
            $result = MyStorage::where('folder', $request['folder'])->update($post);

            return json_encode(['result' => $result, 'status' => true]);
        }
    }

}
