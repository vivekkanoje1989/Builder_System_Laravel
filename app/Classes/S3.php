<?php
/*
 
 * Develope By :Uma Shinde(22-03-2017)
 * purpose : Managing images on AWS S3 Buckets
 * 1) s3Configuration() : This Funcion is use for set access key,secret key,region,bucket dynamically from system_configs table.
 * 2) s3FileUplod() : this function upload image to the s3 bucket with folder name.
                    also pass the image count and image array parameters.
                    It returns comma seperated images name after uploaded
 * 3)s3FileDelete() : delete file from s3 bucket if exist.also pass the parameter folder name for delete under that folder.
                    it returns true if file exist & delete  otherwise return false. 
 * 4)s3FileLists() :listing all files from bucket and it returns files name list in json array.
                    
  */

namespace App\Classes;

use Illuminate\Contracts\Filesystem\Filesystem;
use Config;
use DB;
use App\Models\backend\Employee;
use Auth;

class S3 {

    public static function s3Configuration() {
       // echo Auth::guard('admin')->user()->id;exit;
        $data = DB::table('system_configs')->where('id', 1)->get();
        //print_r($data[0]->aws_bucket_id);exit;
        Config::set('filesystems.disks.s3.bucket', $data[0]->aws_bucket_id);
        Config::set('filesystems.disks.s3.secret', $data[0]->aws_secret_key);
        Config::set('filesystems.disks.s3.key', $data[0]->aws_access_key);
        Config::set('filesystems.disks.s3.driver', 's3');
        Config::set('filesystems.disks.s3.region', 'ap-south-1');
    }

    public static function s3FileUplod($image, $s3FolderName,$cnt) {
        S3::s3Configuration();
        $name = '';
        for ($i = 0; $i < $cnt; $i++) {
            $imageFileName = time() . $i . '.' . $image[$i]->getClientOriginalExtension();
            $imagePath = $image[$i]->getPathName();
            $s3 = \Storage::disk('s3');
            $filePath = '/'.$s3FolderName.'/'. $imageFileName;
            $s3->put($filePath, file_get_contents($imagePath), 'public');
            $name .= ',' . $imageFileName;
        }
        if ($name !== '') {
            return($name);
        }
    }

    public static function s3FileDelete($image,$s3FolderName) {
        S3::s3Configuration();
        $path = '/'.$s3FolderName.'/' . $image;
        if (\Storage::disk('s3')->exists($path)) {
            \Storage::disk('s3')->delete($path);
            return true;
        } else {
            return false;
        }
    }

    public static function s3FileLists($image) {
        S3::s3Configuration();
        $files = \Storage::disk('s3')->allFiles('/support-tickets/');
        if ($files) {
            $result = ['success' => true, 'files' => $files];
            jsjon_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            jsjon_encode($result);
        }
    }

}
