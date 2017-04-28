<?php

/*

 * Developed By :Uma Shinde(22-03-2017)
 * purpose : Managing images on AWS S3 Buckets
 * 1) s3Configuration() : This function is for s3 configuratio. We can set access key,secret key,region,bucket dynamically from system_configs table.
 * 2) s3FileUplod() : This function will upload image to the s3 bucket with folder name.
 * 3)s3FileDelete() : Delete file from s3 bucket if exist. Pass folder name as parameter to delete file under that folder.
  This will return true if file exist, otherwise deletes the file and returns false.
 * 4)s3FileLists() :listing all files from bucket. It returns file names in json array.

 */

namespace App\Classes;

use Illuminate\Contracts\Filesystem\Filesystem;
use Config;
use DB;
use App\Models\backend\Employee;
use App\Models\MyStorage;
use App\Models\StorageFiles;
use Auth;
use App\Http\Requests;
use Session;
use App\Modules\MyStorage\Models\MyStorage;
use App\Modules\MyStorage\Models\StorageFiles;
use App\Classes\CommonFunctions;

class S3 {
    /*
     * s3Configuration function use to set access key,secret key,region,bucket dynamically from system_configs table 
     * if values are not in session otherwise set from session.
     */

    public static function s3Configuration() {

        if (Session::has('bucket')) {
            Config::set('filesystems.disks.s3.bucket', Session::get('bucket'));
            Config::set('filesystems.disks.s3.secret', Session::get('secretKey'));
            Config::set('filesystems.disks.s3.key', Session::get('accessKey'));
            Config::set('filesystems.disks.s3.driver', 's3');
            Config::set('filesystems.disks.s3.region', Session::get('bucketRegion'));
        } else {
            $data = DB::table('system_configs')->where('id', 1)->get();
            session(['bucket' => $data[0]->aws_bucket_id]);
            session(['secretKey' => $data[0]->aws_secret_key]);
            session(['accessKey' => $data[0]->aws_access_key]);
            session(['bucketRegion' => $data[0]->region]);
            Config::set('filesystems.disks.s3.bucket', $data[0]->aws_bucket_id);
            Config::set('filesystems.disks.s3.secret', $data[0]->aws_secret_key);
            Config::set('filesystems.disks.s3.key', $data[0]->aws_access_key);
            Config::set('filesystems.disks.s3.driver', 's3');
            Config::set('filesystems.disks.s3.region', $data[0]->region);
            // session(['s3Path' => 'https://s3.'.$data[0]->region.'.amazonaws.com/'.$data[0]->aws_bucket_id]);
        }
    }

    /*
     * s3FileUplod() used for upload file to s3 bucket
     * parameters-
     *          1)$image - image file temporary name or pathname
     *          2)$imageFileName -image file name which we want to upload with extention
     *          3)$s3FolderName  - folderpath (e.g project/banner-images )
     *          image name is in the form of modulename_id_fourDigitRandomNumber (e.g - website_10_1234.jpg)
     * For App-same as above
     */

    public static function s3FileUplod($image, $imageFileName, $s3FolderName) {
        S3::s3Configuration();
        $s3 = \Storage::disk('s3');
        S3::SaveImageStorage($imageFileName, $s3FolderName);
        $filePath = '' . $s3FolderName . '/' . $imageFileName;
        $val = $s3->put($filePath, file_get_contents($image), 'public');
        if ($val) {
            $result = ['success' => true, 'message' => 'File Uploaded Successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'files' => 'File not upload'];
            return json_encode($result);
        }
    }

    /*
     * s3FileDelete() used for delete file from perticular path
     * return 1 if existed file is delete otherwise return 0
     */

    public static function s3FileDelete($path) {
        S3::s3Configuration();
        if (\Storage::disk('s3')->exists($path)) {
            \Storage::disk('s3')->delete($path);
            return true;
        } else {
            return false;
        }
    }

    /*
     * 
     */

    public static function s3FolderDelete($filepath) {
        S3::s3Configuration();
        $path = '/' . $filepath;
        if (\Storage::disk('s3')->deleteDirectory($path)) {
            return true;
        } else {
            return false;
        }
    }

    public static function s3FileLists($filename) {
        S3::s3Configuration();
        $files = \Storage::disk('s3')->allFiles($filename);
        if ($files) {
            $result = ['success' => true, 'files' => $files];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3AllDirectories() {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->Directories();
        if ($directories) {
            $result = ['success' => true, 'directories' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3Directories() {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->allDirectories();
        if ($directories) {
            $result = ['success' => true, 'directories' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3CreateDirectory($directory) {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->makeDirectory($directory);
        if ($directories) {
            $result = ['success' => true, 'directory' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3DeleteDirectory($directory) {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->deleteDirectory($directory);
        if ($directories) {
            $result = ['success' => true, 'directory' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3CreateSubDirectory($foldername, $directory) {
        S3::s3Configuration();
        $s3 = \Storage::disk('s3');
        $filePath = '/' . $foldername . '/' . $directory;
        $directories = $s3->put($directory, $filePath, 'public');
        if ($directories) {
            $result = ['success' => true, 'files' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3DirectoryLists() {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->allDirectories();
        if ($directories) {
            $result = ['success' => true, 'directories' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function SaveImageStorage($filename, $folderName) { //Manoj 

       $loggedInUserId = Auth::guard('admin')->user()->id;
       $position = strrpos($folderName, '/');
       if ($position > 0) {
           $MainFolder = strstr($folderName, '/', true);
           $MainFolderCount = MyStorage::where('folder', '=', $MainFolder)->get()->count();
           if ($MainFolderCount == '0') {
               $post = ['folder' => $MainFolder];
               $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
               $newFolder = array_merge($common, $post);
               MyStorage::create($newFolder);
           }

           $folder = str_replace('/', '', strstr($folderName, '/'));
           $count = MyStorage::where('folder', '=', $folder)->get()->count();
           if ($count == 0) {
               $post = ['folder' => $folder];
               $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
               $newFolder = array_merge($common, $post);
               $newFolder['sub_folder_status'] = '1';
               MyStorage::create($newFolder);
               $last3 = MyStorage::latest('id')->first();
               $subFolders = MyStorage::where('folder', '=', $MainFolder)->select('sub_folder')->first();
               if (!empty($subFolders->sub_folder)) {
                   $sub_folder = $subFolders->sub_folder . "," . $last3->id;
               } else {
                   $sub_folder = $last3->id;
               }
               MyStorage::where('folder', '=', $MainFolder)->update(['sub_folder' => $sub_folder]);
           }
       
       } else {
           $MainFolder = strstr($folderName, '/', true);
           $folder = $MainFolder;
           $MainFolderCount = MyStorage::where('folder', '=', $MainFolder)->get()->count();
           if ($MainFolderCount == '0') {
               $post = ['folder' => $MainFolder];
               $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
               $newFolder = array_merge($common, $post);
               MyStorage::create($newFolder);
           }
       }
       $getId = MyStorage::where('folder', '=', $folder)->select('id')->first();
       $post = [
           'file_name' => $filename,
           'file_url' => $folderName . "/" . $filename,
           'storage_id' => $getId->id,
       ];
       $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
       $allData = array_merge($common, $post);
       StorageFiles::create($allData);
   }
}
