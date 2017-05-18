<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 //$data = DB::table('system_configs')->where('id', 1)->get();
return [
    'getUrl' => 'office',
    'getWebsiteUrl' => 'website',
    'companyName' => 'BMS BUILDER',
    'rootPath' => base_path(),
    'randomNoDigits'=>4,
    's3Path'=>"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/",
    'themeName'=>'',
];