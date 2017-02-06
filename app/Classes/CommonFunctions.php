<?php
namespace App\Classes;

use DB;

class CommonFunctions {

    public static function getMacAddress(){
        // Turn on output buffering  
        ob_start();  
        //Get the ipconfig details using system commond  
        system('ipconfig /all');  
        // Capture the output into a variable  
        $mycomsys=ob_get_contents();  
        // Clean (erase) the output buffer  
        ob_clean();  
        $find_mac = "Physical"; //find the "Physical" & Find the position of Physical text  
        $pmac = strpos($mycomsys, $find_mac);  
        // Get Physical Address  
        $macaddress=substr($mycomsys,($pmac+36),17);  
        //Display Mac Address  
        return $macaddress;  
    }
    public static function insertLoginLog($mobile, $password, $empId, $loginStatus, $loginFailureReason){
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d h:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = \Location::get("175.100.138.136");
//        $otherInfo = ['Country' => $data->countryName,'State' => $data->regionName, 'City' => $data->cityName, 'Latitude' => $data->latitude, 'Longitude' => $data->longitude];
        $otherInfo = "Country:$data->countryName,State:$data->regionName,City:$data->cityName,Latitude:$data->latitude,Logitude:$data->longitude";
        $otherInfo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $otherInfo);
        DB::select('CALL employees_login_logs('.$empId.',"'.$mobile.'","'.$password.'","'.$loginDateTime.'",'.$loginStatus.','.$loginFailureReason.',1,"'.$loginIP.'","'.$loginBrowser.'","'.$loginMacId.'","'.$otherInfo.'")');
    }
    
}
