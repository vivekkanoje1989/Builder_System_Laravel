<?php

/*

 * Developed By :Uma Shinde(22-03-2017)
 * purpose : Managing images on AWS S3 Buckets
 * 1) s3Configuration() : This function is for s3 configuratio. We can set access key,secret key,region,bucket dynamically from system_configs table.
 * 2) s3FileUplod() : This function will upload image to the s3 bucket with folder name.
  Also pass the image count and image array as parameters.
  It returns comma seperated images name after uploaded
 * 3)s3FileDelete() : Delete file from s3 bucket if exist. Pass folder name as parameter to delete file under that folder.
  This will return true if file exist, otherwise deletes the file and returns false.
 * 4)s3FileLists() :listing all files from bucket. It returns file names in json array.

 */

namespace App\Classes;

use Illuminate\Contracts\Filesystem\Filesystem;
use Config;
use DB;
use App\Models\backend\Employee;
use Auth;

class S3 {

    public static function s3Configuration() {
        $data = DB::table('system_configs')->where('id', 1)->get();
        Config::set('filesystems.disks.s3.bucket', $data[0]->aws_bucket_id);
        Config::set('filesystems.disks.s3.secret', $data[0]->aws_secret_key);
        Config::set('filesystems.disks.s3.key', $data[0]->aws_access_key);
        Config::set('filesystems.disks.s3.driver', 's3');
        Config::set('filesystems.disks.s3.region', 'ap-south-1');
    }
    public static function s3FileUplod($image, $s3FolderName, $cnt) {
        S3::s3Configuration();
        $name = '';
        for ($i = 0; $i < $cnt; $i++) {
            $imageFileName = time() . $i . '.' . $image[$i]->getClientOriginalExtension();
            $imagePath = $image[$i]->getPathName();
            $s3 = \Storage::disk('s3');
            $filePath = '/' . $s3FolderName . '/' . $imageFileName;
            $s3->put($filePath, file_get_contents($imagePath), 'public');
            $name .= ',' . $imageFileName;
        }
        if ($name !== '') {
            return($name);
        }
    }
    public static function s3FileUplodForApp($image, $s3FolderName, $cnt) {
        S3::s3Configuration();
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFileName = time() . '.' . $ext;
        $imagePath = $image['tmp_name'];
        $s3 = \Storage::disk('s3');
        $filePath = '/' . $s3FolderName . '/' . $imageFileName;
        $s3->put($filePath, file_get_contents($imagePath), 'public');
        return $imageFileName;
    }
    public static function s3FileDelete($filepath) {
        S3::s3Configuration();
        $path = '/' . $filepath;
        if (\Storage::disk('s3')->exists($path)) {
            \Storage::disk('s3')->delete($path);
            return true;
        } else {
            return false;
        }
    }
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
    public static function s3CreateDirectory($directory) {
        S3::s3Configuration();
        $directories = \Storage::disk('s3')->makeDirectory($directory);
        if ($directories) {
            $result = ['success' => true, 'files' => $directories];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public static function s3SubCreateDirectory($foldername, $directory) {
        S3::s3Configuration();
        //$directories = \Storage::disk('s3')->makeDirectory($directory);
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

}
