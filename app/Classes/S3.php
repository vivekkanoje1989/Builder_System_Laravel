<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
        //$bucket = 'bmsbuilderv2';
        Config::set('filesystems.disks.s3.bucket', $data[0]->aws_bucket_id);
        Config::set('filesystems.disks.s3.secret', $data[0]->aws_secret_key);
        Config::set('filesystems.disks.s3.key', $data[0]->aws_access_key);
        Config::set('filesystems.disks.s3.driver', 's3');
        Config::set('filesystems.disks.s3.region', 'ap-south-1');
    }

   /* public static function s3FileUplod($image, $s3FolderName,$cnt) {
        S3::s3Configuration();
        $name = '';
        $random = rand(1,1000);
        for ($i = 0; $i < $cnt; $i++) {
            $imageFileName = time().'_'.$random . '.' . $image[$i]->getClientOriginalExtension();
            $imagePath = $image->getPathName();
            $s3 = \Storage::disk('s3');
            $filePath = '/'.$s3FolderName.'/'. $imageFileName;
            $s3->put($filePath, file_get_contents($imagePath), 'public');
            $name .= ',' . $imageFileName;
        }
        if ($name !== '') {
            return($name);
        }
    }*/
    
    public static function s3FileUpload($filepath,$filename, $s3FolderName) {

        S3::s3Configuration();        
        $name = '';
        $s3 = \Storage::disk('s3');
        $s3Path = '/'.$s3FolderName.'/'. $filename;echo $s3Path;
        $s3->put($s3Path, file_get_contents($filepath), 'public');
        if ($filename !== '') {
            return($filename);
        }
    }
    
    
    public static function s3FileUploadForApp($image, $s3FolderName, $cnt) {
        S3::s3Configuration();
        //for ($i = 0; $i < $cnt; $i++) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFileName = time() . '.' . $ext;
        $imagePath = $image['tmp_name'];
        $s3 = \Storage::disk('s3');
        $filePath = '/' . $s3FolderName . '/' . $imageFileName;
        $s3->put($filePath, file_get_contents($imagePath), 'public');
        return $imageFileName;
   }

    public static function s3FileDelete($s3FolderName) {
        S3::s3Configuration();
//        echo $image;exit;
        $path ='/'.$s3FolderName;
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
