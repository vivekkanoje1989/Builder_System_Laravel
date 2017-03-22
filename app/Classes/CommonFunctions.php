<?php
namespace App\Classes;

use DB;
use Auth;
class CommonFunctions {

    public static function getMacAddress(){
        exec('netstat -ie', $result);
        if(is_array($result)) {
          $iface = array();
          foreach($result as $key => $line) {
            if($key > 0) {
              $tmp = str_replace(" ", "", substr($line, 0, 10));
              if($tmp <> "") {
                $macpos = strpos($line, "HWaddr");
                if($macpos !== false) {
                  $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
                }
              }
            }
          }
          return $iface[0]['mac'];
        } 
        else 
        {
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
    }
    public static function insertLoginLog($mobile, $password, $empId, $loginStatus, $loginFailureReason){
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d h:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = \Location::get("175.100.138.136");
        $otherInfoArray = "Country:$data->countryName,State:$data->regionName,City:$data->cityName,Latitude:$data->latitude,Logitude:$data->longitude";
        $otherInfo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $otherInfoArray);
        DB::select('CALL employees_login_logs('.$empId.',"'.$mobile.'","'.$password.'","'.$loginDateTime.'",'.$loginStatus.','.$loginFailureReason.',1,"'.$loginIP.'","'.$loginBrowser.'","'.$loginMacId.'","'.$otherInfo.'")');
    }
    public static function insertMainTableRecords($loggedInUserId){
        $getMacAddress = CommonFunctions::getMacAddress();      
        $create = ['created_date' => date('Y-m-d'), 'created_by' => $loggedInUserId, 'created_IP' => $_SERVER['REMOTE_ADDR'], 'created_browser' => $_SERVER['HTTP_USER_AGENT'], 'created_mac_id' => $getMacAddress];
        return $create;
    }
    
    public static function updateMainTableRecords($loggedInUserId){
        $getMacAddress = CommonFunctions::getMacAddress();
        $create = ['updated_date' => date('Y-m-d'), 'updated_by' => $loggedInUserId, 'updated_IP' => $_SERVER['REMOTE_ADDR'], 'updated_browser' => $_SERVER['HTTP_USER_AGENT'], 'updated_mac_id' => $getMacAddress];
        return $create;
    }
    public static function checkPlatform(){
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$userAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($userAgent,0,4)))
        {
            return true; 
        }
        else return false;
    }
    
}
