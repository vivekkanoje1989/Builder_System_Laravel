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
    // google storage
    public static function s3Configuration() {
       $data = DB::table('system_configs')->where('id', 1)->get();
       
     //  Config::set('filesystems.disks.gcs.bucket', $data[0]->aws_bucket_id);
        Config::set('filesystems.disks.gcs.bucket', 'bkt_bms_laravel');
       Config::set('filesystems.disks.gcs.project_id','756686641793');
       Config::set('filesystems.disks.gcs.driver', 'gcs');
        
    }

    public static function s3FileUplod($image, $s3FolderName,$cnt) {
        S3::s3Configuration();
        $name = '';
        $random = rand(1,1000);
        //print_r($image);exit;
        for ($i = 0; $i < $cnt; $i++) {
            $imageFileName = time().'_'.$random . $i . '.' . $image[$i]->getClientOriginalExtension();
            $imagePath = $image[$i]->getPathName();
            
            $disk = \Storage::disk('gcs');
            $filePath = '/'.$s3FolderName.'/'. $imageFileName;
            $disk->put($filePath, file_get_contents($imagePath));
            
            $name .= ',' . $imageFileName;
        }
        if ($name !== '') {
            return($name);
        }
    }
    
    
    // google storage
     public static function s3FileUpload($filepath,$filename, $s3FolderName) {
        
        S3::s3Configuration();

        $name = '';
        $disk = \Storage::disk('gcs');
        $s3Path = $s3FolderName.'/'. $filename;
        $disk->put($s3Path, file_get_contents($filepath));
        $name = $filename;
        if ($name !== '') {
            return($name);
        }
    }
    
    public static function s3FileUplodForApp($image, $s3FolderName, $cnt) {
        S3::s3Configuration();
        //for ($i = 0; $i < $cnt; $i++) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFileName = time() . '.' . $ext;
        $imagePath = $image['tmp_name'];
        
        $disk = \Storage::disk('gcs');
        $filePath = '/'.$s3FolderName.'/'. $imageFileName;
        $disk->put($filePath, file_get_contents($imagePath));
        
        return $imageFileName;
   }

    public static function s3FileDelete($s3FolderName) {
        S3::s3Configuration();
        if (\Storage::disk('gcs')->exists($s3FolderName)) {
            \Storage::disk('gcs')->delete($s3FolderName);
            return true;
        } else {
            return false;
        }
    }

    public static function s3FileLists($image) {
        S3::s3Configuration();
        $files = \Storage::disk('gcs')->allFiles('/support-tickets/');
        if ($files) {
            $result = ['success' => true, 'files' => $files];
            json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            json_encode($result);
        }
    }
    public static function s3CreateSubDirectory($newFolder,$mainFolder) {
        S3::s3Configuration();
        $files = \Storage::disk('gcs')->makeDirectory($mainFolder."/".$newFolder);
        if ($files) {
            $result = ['success' => true, 'files' => $files];
            json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            json_encode($result);
        }
    }
    public static function s3CreateDirectory($newFolder) {
        S3::s3Configuration();
        $files = \Storage::disk('gcs')->makeDirectory($newFolder);
        if ($files) {
            $result = ['success' => true, 'files' => $files];
            json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            json_encode($result);
        }
    }

}
//class S3 {
//
//    public static function s3Configuration() {
//        // echo Auth::guard('admin')->user()->id;exit;
//        $data = DB::table('system_configs')->where('id', 1)->get();
//        //print_r($data[0]->aws_bucket_id);exit;
//        //$bucket = 'bmsbuilderv2';
//        Config::set('filesystems.disks.gcs.bucket', $data[0]->aws_bucket_id);
////        Config::set('filesystems.disks.gcs.bucket', 'bkt_lms');
//        Config::set('filesystems.disks.gcs.project_id', '756686641793');
//        Config::set('filesystems.disks.gcs.driver', 'gcs');
//    }
//
//    public static function s3FileUpload($filepath, $filename, $s3FolderName) {
//
//
//        S3::s3Configuration();
//        $name = '';
//        $s3 = \Storage::disk('gcs');
//        $s3Path = '/' . $s3FolderName . '/' . $filename;
//        $s3->put($s3Path, file_get_contents($filepath), 'public');
//        if ($filename !== '') {
//            return($filename);
//        }
//    }
//
//    public static function s3FileUploadForApp($image, $s3FolderName, $cnt) {
//        S3::s3Configuration();
//        //for ($i = 0; $i < $cnt; $i++) {
//        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
//        $imageFileName = time() . '.' . $ext;
//        $imagePath = $image['tmp_name'];
//        $s3 = \Storage::disk('s3');
//        $filePath = '/' . $s3FolderName . '/' . $imageFileName;
//        $s3->put($filePath, file_get_contents($imagePath), 'public');
//        return $imageFileName;
//    }
//
//    public static function s3FileDelete($s3FolderName) {
//        S3::s3Configuration();
////        echo $image;exit;
//        $path = '/' . $s3FolderName;
//        if (\Storage::disk('s3')->exists($path)) {
//            \Storage::disk('s3')->delete($path);
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    public static function s3FileLists($image) {
//        S3::s3Configuration();
//        $files = \Storage::disk('s3')->allFiles('/support-tickets/');
//        if ($files) {
//            $result = ['success' => true, 'files' => $files];
//            jsjon_encode($result);
//        } else {
//            $result = ['success' => false, 'message' => 'Something Went Wrong'];
//            jsjon_encode($result);
//        }
//    }
//
//}
