<?php

namespace App\Modules\MyStorage\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\S3;
use Illuminate\Support\Facades\Input;
use App\Modules\MyStorage\Models\MyStorage;
use App\Modules\MyStorage\Models\StorageFiles;
use Auth;
use DB;
use App\Classes\CommonFunctions;

class MyStorageController extends Controller {

    public function index() {
        return view("MyStorage::index");
    }

    public function getStorage() {
        // $result = S3::s3AllDirectories();
        $result = MyStorage::where(['deleted_status' => '0', 'sub_folder_status' => '0'])->get();

        return json_encode(['result' => $result, 'status' => true]);
    }

    public function allFiles($folderId) {
        return view("MyStorage::allimages")->with("folderId", $folderId);
    }

    public function sharedWithMe() {
        return view("MyStorage::sharedwithme");
    }

    public function recycleBin() {
        return view("MyStorage::recyclebin");
    }

    public function getAllListToRestore($folderId) {
        return view("MyStorage::listtorestore")->with("folderId", $folderId);
    }

    public function getSubFolderImages($folderId) {
        return view("MyStorage::subfolderimages")->with("folderId", $folderId);
    }

    public function allMyFiles($folderId) {
        return view("MyStorage::allmyimages")->with("folderId", $folderId);
    }

    public function SubFolderRestore($folderId) {
        return view("MyStorage::subfolderrestore")->with("folderId", $folderId);
    }

    public function getMySubFolderImages($folderId) {
        return view("MyStorage::mysubfolderimages")->with("folderId", $folderId);
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
        $result = MyStorage::where('id', $request['id'])->first();
        $emp = DB::table('employees')->where('id', $request['share_with'])->select(['first_name', 'last_name'])->first();

        $share = explode(',', $result['share_with']);
        if (!(in_array($request['share_with'], $share))) {
            if (!empty($result['share_with'])) {
                $share_with = $result['share_with'] . ',' . $request['share_with'];
            } else {
                $share_with = $request['share_with'];
            }
            $post = ['share_with' => $share_with];
            $update = MyStorage::where('id', $request['id'])->update($post);
            return json_encode(['result' => $update, 'empl' => $emp, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'Folder already shared with employee', 'empl' => $emp, 'status' => false]);
        }
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

    public function folderStorage() {
        try {
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
            $cnt = MyStorage::where(['folder' => $request['folderName']])->get()->count();
            if ($cnt > 0) {
                $result = ['success' => false, 'errorMsg' => 'Sub folder already exists'];
                return json_encode($result);
            } else {
                $post = ['folder' => $request['folderName']];
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['storeData'] = array_merge($post, $create);
                $input['storeData']['sub_folder_status'] = '1';

                $bucket = MyStorage::where('id', $request['folder'])->select('folder', 'sub_folder')->first();

                $result = S3::s3CreateSubDirectory($bucket->folder, $request['folderName']);
                $dbresult = MyStorage::create($input['storeData']);
                $lastId = MyStorage::latest('id')->first();
                if (!empty($bucket->sub_folder)) {
                    $sub_bucket = $bucket->sub_folder . "," . $lastId->id;
                } else {
                    $sub_bucket = $lastId->id;
                }
                $dbresult = MyStorage::where('id', $request['folder'])->update(['sub_folder' => $sub_bucket]);
                $result = ["status" => true, 'result' => $dbresult, 'id' => $lastId->id];
                return json_encode($result);
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }

    public function getRecycleList() {
        $result = MyStorage::where('deleted_status', '1')->get();
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function getMyStorage() {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $query = MyStorage::whereRaw('find_in_set(?, share_with)', $loggedInUserId)->where('deleted_status', '0')->get();
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
        $result = MyStorage::where('id', $request['id'])->update($input['folderData']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function restoreFolder() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['deleted_status'] = '0';
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['folderData'] = array_merge($request, $create);
        $result = MyStorage::where('id', $request['id'])->update($input['folderData']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function allFolderImages() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = StorageFiles::where(['storage_id' => $request['id']])->get(['id', 'storage_id', 'file_name', 'file_url']);
        if (!empty($result)) {
            $result = ['status' => true, 'records' => $result];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function subFolder() {
        $input = Input::all();
        if (!empty($input['fileName']['fileName'])) {
            $originalName = $input['fileName']['fileName']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $res = MyStorage::where('id', $input['id'])->select('folder')->first();
                $s3FolderName = $res->folder;
                $imageName = 'storage_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['fileName']['fileName']->getClientOriginalExtension();
                S3::s3FileUpload($input['fileName']['fileName']->getPathName(), $imageName, $s3FolderName);
                $FileName = $imageName;

                $post = ['file_name' => $FileName, 'storage_id' => $input['id'], 'file_url' => $s3FolderName . '/' . $FileName];
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['fileData'] = array_merge($post, $create);

                $result = StorageFiles::create($input['fileData']);
                $lastId = MyStorage::latest('id')->first();
                return json_encode(['result' => $res->folder . '/' . $FileName, 'lastId' => $lastId->id, 'status' => true]);
            } else {
                unset($input['blog_banner_images']);
                $banner_images = '';
                return json_encode(['errorMsg' => 'No Image selected', 'status' => false]);
            }
        }
    }

    public function subImageStorage() {
        $input = Input::all();
        if (!empty($input['fileName']['fileName'])) {
            $originalName = $input['fileName']['fileName']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $res = MyStorage::where('id', $input['id'])->select('folder')->first();
                $query = MyStorage::whereRaw(
                                'find_in_set(?, sub_folder)', $input['id'])->where('deleted_status', '0')->first();
                if (!empty($query->folder)) {
                    $s3FolderName = $query->folder . "/" . $res->folder;
                    $imageName = 'storage_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['fileName']['fileName']->getClientOriginalExtension();
                    S3::s3FileUpload($input['fileName']['fileName']->getPathName(), $imageName, $s3FolderName);
                    $FileName = $imageName;
                    $post = ['file_name' => $FileName, 'storage_id' => $input['id'], 'file_url' => $s3FolderName . '/' . $FileName];
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                    $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $input['fileData'] = array_merge($post, $create);
                    $result = StorageFiles::create($input['fileData']);
                    $lastId = StorageFiles::latest('id')->first();
                    return json_encode(['result' => $s3FolderName . '/' . $FileName, 'lastId' => $lastId->id, 'status' => true]);
                }
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
        $deletedResult = StorageFiles::where('id', $request['id'])->delete();
        return json_encode(['result' => $deletedResult, 'status' => true]);
    }

    public function folderSharedEmployees() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = MyStorage::where('id', $request['id'])->select('share_with')->first();
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

        $result = MyStorage::where('id', $request['id'])->select('share_with')->first();
        if ($result->share_with) {
            $employee_id = explode(',', $result->share_with);
            $unique = array_unique($employee_id);
            $pos = array_search($request['employee_id'], $unique);
            unset($unique[$pos]);
            $share = implode(',', $unique);
            $post = ['share_with' => $share];
            $result = MyStorage::where('id', $request['id'])->update($post);
            return json_encode(['result' => $result, 'status' => true]);
        }
    }

    public function getSubDirectory() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $result = MyStorage::where('id', $request['id'])->first();

        if (!empty($result->sub_folder)) {

            $sub_bucket = explode(',', $result->sub_folder);
            $subBuckets = [];
            for ($i = 0; $i < count($sub_bucket); $i++) {

                $result = MyStorage::where(['id' => $sub_bucket[$i]])->first();
                if ($result->deleted_status == '0') {
                    array_push($subBuckets, ['id' => $result->id, 'folder' => $result->folder]);
                }
            }
            return json_encode(['result' => $subBuckets, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'Sub folders not availble', 'status' => false]);
        }
    }

    public function sharedImageWith() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = StorageFiles::where('id', $request['id'])->first();
        $emp = DB::table('employees')->where('id', $request['share_with'])->select(['first_name', 'last_name'])->first();
        $share = explode(',', $result['share_with']);
        if (!(in_array($request['share_with'], $share))) {
            if (!empty($result['share_with'])) {
                $share_with = $result['share_with'] . ',' . $request['share_with'];
            } else {
                $share_with = $request['share_with'];
            }
            $post = ['share_with' => $share_with];
            $update = StorageFiles::where('id', $request['id'])->update($post);
            return json_encode(['result' => $update, 'empl' => $emp, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'Employee already assigned', 'empl' => $emp, 'status' => false]);
        }
    }

    public function removeImageSharedEmp() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = StorageFiles::where('id', $request['image_id'])->select('share_with')->first();
        if ($result->share_with) {
            $employee_id = explode(',', $result->share_with);
            $unique = array_unique($employee_id);
            $pos = array_search($request['employee_id'], $unique);
            unset($unique[$pos]);
            $share = implode(',', $unique);
            $post = ['share_with' => $share];
            $result = StorageFiles::where('id', $request['image_id'])->update($post);
            return json_encode(['result' => $result, 'status' => true]);
        }
    }

    public function getSharedImagesEmployees() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = StorageFiles::where('id', $request['id'])->select('share_with')->first();
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

    public function getMySharedImages() {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $myShared = StorageFiles::whereRaw(
                        'find_in_set(?, share_with)', $loggedInUserId)->get();
        if (!empty($myShared)) {
            $result = ['status' => true, 'records' => $myShared];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function synchedFolderList() {
        $result = S3::s3AllDirectories();
        $result2 = MyStorage::where(['deleted_status' => '0', 'sub_folder_status' => '0'])->get(['folder']);
        return json_encode(['result' => $result, 'result2' => $result2, 'status' => true]);
    }

    public function insertSyncedData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        for ($i = 0; $i < count($request['difference']); $i++) {
            $post = ['folder' => $request['difference'][$i]];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['storeData'] = array_merge($post, $create);
            $dbresult = MyStorage::create($input['storeData']);
        }
        return json_encode(["status" => true, 'result' => 'inserted']);
    }

    public function subDirectoryAdd() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $folders = [];
        $cnt = MyStorage::where(['id' => $request['id']])->first();
        $result = S3::s3AllDirectories();
        $result2 = S3::s3Directories();
        $query = MyStorage::where('id', $request['id'])->first();
        if (!empty($query->sub_folder)) {
            $share_with = explode(',', $query->sub_folder);
            for ($i = 0; $i < count($share_with); $i++) {

                $queryResult = MyStorage::where(['id' => $share_with[$i]])->first();
                if (!empty($queryResult->folder)) {
                    array_push($folders, $queryResult->folder);
                }
            }
        }
        return json_encode(['result' => $result, 'result2' => $result2, 'folder' => $cnt->folder, 'oldFolder' => $folders, 'subId' => $query->sub_folder, 'status' => true]);
    }

    public function syncSubFolderCreate() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $updateFolder = '';
        $allResult = [];
        for ($i = 0; $i < count($request['syncSubFolder']); $i++) {
            $post = ['folder' => $request['syncSubFolder'][$i]];
            $input['storeData'] = array_merge($post, $create);
            $input['storeData']['sub_folder_status'] = '1';
            $result = MyStorage::create($input['storeData']);
            $lastId = MyStorage::latest('id')->first();
            $getData = ['folder' => $request['syncSubFolder'][$i], 'id' => $lastId->id];
            array_push($allResult, $getData);
            if (!empty($request['subId'])) {
                $updateFolder .= $lastId->id;
            } else {
                $updateFolder .= ',';
                $updateFolder .= $lastId->id;
            }
        }
        $update = MyStorage::where('id', $request['id'])->update(['sub_folder' => trim($updateFolder, ",")]);
        return json_encode(["result" => $allResult, "status" => true]);
    }

}
