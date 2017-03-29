<?php

namespace App\Classes;

use Auth;
use App\Models\VasCredit;
use App\Models\EmailPassword;
use App\Models\SmsLog;
use App\Models\SystemConfig;
use App\Models\EmailLog;
use DB;
use App\Mail\MailConfig;
use Maatwebsite\Excel\Facades\Excel;

class Gupshup {

    public static function sendSMS($smsBody, $mobileNo, $loggedInUserId, $customer, $customerId, $isInternational = 0, $sendingType = 1, $smsType) {
        try{
            if (!empty(trim($mobileNo))) {
                $fromDate = date("Y-m-d 00:00:00", strtotime("first day of this month"));
                $toDate = date("Y-m-d 23:59:59", strtotime("last day of this month"));

                $logs = SmsLog::selectRaw("sum(credits_deducted) AS credits_deducted")->whereBetween('sent_date_time', array($fromDate, $toDate))->first();
                $smsConsume = $logs['credits_deducted'];

                $totalSmsCredits = VasCredit::select('sms_credit_limit', 'sms_status')->where(['id' => 1])->get();

                if ($totalSmsCredits[0]['sms_status'] == '1') {
                    if ($totalSmsCredits[0]['sms_credit_limit'] >= $smsConsume) {
                        
                        if ($smsType == "P_SMS") { //Promossional SMS
                            //$smsApi = EmailPassword::select('email_id', 'email_pwd', 'client_id', 'type', 'system_id')->where(['id' => 1])->get(); //sms credentials
                            if ($sendingType == 1) {
                                $msgType = "TEXT";
                            } elseif ($sendingType == 2) {
                                $msgType = "FLASH";
                            }
                            $smsType = "P_sms";
                            $userId = "2000161554";
                            $password = "Nextedge@2016#";
                        } else { //Transactional SMS
                            //$smsApi = EmailPassword::select('email_id', 'email_pwd', 'client_id', 'type', 'system_id')->where(['id' => 2])->get(); //sms credentials
                            $smsType = "T_sms";
                            $msgType = "TEXT";
                            $userId = "2000161552";
                            $password = "Nextedge@2016#";
                            if ($customer == 'Yes'){
                                $mask = "EDDEMO";}
                            else{
                                $mask = "BMSSYS";}
                        }

                        $clientData = SystemConfig::select('client_id')->where(['id' => 1])->get(); //get client id
                        $clientId = $clientData[0]['client_id'];
                        $clientType = '';
                        $request = ""; //initialise the request variable                    
                        if ($isInternational == 1) {
                            $userId = "2000163069";
                            $password = "Nextedge@2016#";
                        } 
                        

                        $param = ["method" => "sendMessage", "send_to" => $mobileNo, "msg" => $smsBody, "userid" => $userId, "password" => $password, "mask" => $mask, "v" => "1.1", "msg_type" => $msgType, "auth_scheme" => "PLAIN"];
                        //Have to encode the url values 
                        foreach ($param as $key => $val) {
                            $request .= $key . "=" . urlencode($val); //we have to urlencode the values 
                            $request .= "&"; //append the ampersand (&) sign after each parameter/value pair 
                        }
                        $request = substr($request, 0, strlen($request) - 1); //remove final (&) sign from the request 
                        $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $curl_scraped_page = curl_exec($ch);
                        curl_close($ch);

                        //$curl_scraped_page = "success | 917709026395 | 3270637570192393521-331166354051551677";
                        $result = @explode('|', $curl_scraped_page);
                        if ($result[0] == 'success ') {
                            $totalChar = strlen($smsBody);
                            $smsBody = addslashes($smsBody);
                            $status = $result[0];
                            $externalId = @explode('-', $result[2]);
                            $externalId1 = trim($externalId[0]);
                            $externalId2 = trim($externalId[1]);

                            $j = 1;
                            if ($totalChar > 160)
                                $j = 2;
                            if ($totalChar > 320)
                                $j = 3;
                            $creditsDeducted = $j;

                            if ($isInternational == 1) {
                                $creditsDeducted = $j * 2; //when send the sms international credit deducted 2
                            }
                            /***************P_SMS****************/
                            if ($sendingType == 2)
                                $creditsDeducted = $j * 2;
                            /***************P_SMS****************/

                            $date = date("Y-m-d H:i:s");
                            $bulkSms = $fileName = '0';
                            $deliveredTS = $deliveredStatus = $cause = $requestUrl = $logStatus = "";
                            $mobileNoArr = @explode(',', $mobileNo);
                            foreach ($mobileNoArr as $num) {
                                $input[] = ["employee_id" => $loggedInUserId, "sent_date_time" => $date, "client_id" => $clientId, "client_type" => "$clientType", "externalId1" => "$externalId1", "externalId2" => "$externalId2", "deliveredTS" => "$deliveredTS", "mobile_number" => "$result[1]", "sms_body" => $smsBody, "customer_sms" => "$customer", "customer_id" => $customerId, "bulk_sms" => "$bulkSms", "bulk_file_id" => "$fileName", "sms_type" => "$smsType", "status" => $status, "delivered_status" => $deliveredStatus, "cause" => "$cause", "request_url" => $requestUrl, "log_status" => $logStatus, "credits_deducted" => $creditsDeducted, "is_international" => $isInternational];   
                            }
                            $insertSmsLog = Gupshup::smslog($input);

                            /* if ($insertSmsLog == 1) {
                              $sql = "INSERT INTO smsgupshup_realtimereport (am_uid, sent_date_time, client_id, client_type, externalId1, externalId2, deliveredTS, mobile_number, sms_body, customer_sms, customer_id, bulk_sms, bulk_file_id, sms_type,sms_sending_type, status, delivered_status, cause, request_url, log_status,credits_deducted) values ";
                              $sql .= implode(',', $valuesArr);
                              $bulkSms = '0';
                             * 
                              $curl = curl_init();
                              // Set some options - we are passing in a useragent too here
                              curl_setopt_array($curl, array(
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_URL => "http://edynamics.co.in/office.php/realtimereport/smsLog?",
                              CURLOPT_USERAGENT => 'cURL Request',
                              CURLOPT_POST => true,
                              CURLOPT_POSTFIELDS => array(
                              sql => $sql,
                              bulk_sms => $bulkSms,
                              )
                              ));
                              // Send the request & save response to $resp
                              $resp = curl_exec($curl);
                              // Close request to clear up some resources
                              curl_close($curl);
                              if ($resp == 1) {
                              return TRUE;
                              }
                              } */
                            $result = ["success" => true, "status" => 200, "message" => "SMS sent sucessfully"];
                            return json_encode($result);
                        } else {
                            $result = ["success" => false, "status" => 500, "message" => "Server error please try again"];
                            return json_encode($result);
                        }
                    } else {
                        $userName = "support@edynamics.co.in";
                        $password = "edsupport@2016#";
                        $mailBody = "Your SMS creadit limit is over , So Please recharge your account " . "<br><br>" . "Thank You!";
                        $companyName = config('global.companyName');
                        $subject = "Mail subject";
                        $data = ['mailBody' => $mailBody, "fromEmail" => "support@edynamics.co.in", "fromName" => $companyName, "subject" => $subject, "to" => "geeta.gurram@gmail.com", "cc" => "umabshinde@gmail.com"];
                        $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);

                        if($sentSuccessfully == 1){
                            $result = ["success" => false, "status" => 509, "message" => "Credit Limit exceeded please contact to BMS admin"];
                            return json_encode($result);
                        }elseif (!empty(Mail::failures())) {
                            $result = ["success" => false, "status" => 509, "message" => "Insufficient creadit Limit"];
                            return json_encode($result);
                        }
                    }
                } else {
                    $result = ["success" => false, "status" => 401, "message" => "Account is deactivated or suspended"];
                    return json_encode($result);
                }
            } else {
                $result = ["success" => false, "status" => 404, "message" => "Mobile number not found"];
                return json_encode($result);
            }
        }
        catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }
    
    public static function sendBulkSMS($data) {
        try{
                       
            $loggedInUserId = Auth::guard('admin')->user()->id;  
            $filePath = $data['filePath'];
            $fileName = $data['fileName'];
            $sendingType = $data['sendingType'];
            $totalSmsCredits = VasCredit::select('sms_credit_limit', 'sms_status')->where(['id' => 1])->get();
            //$smsApi = EmailPassword::select('email_id', 'email_pwd', 'type')->where(['id' => 1])->get(); //sms credentials

            if ($totalSmsCredits[0]['sms_status'] == '1') {
                $smsBody = $data['textSmsBody'];
                if ($sendingType == 1) {
                    $msgType = "TEXT";
                } elseif ($sendingType == 2) {
                    $msgType = "FLASH";
                }
                $customer = 'YES';
                $customerId = 1;
                $bulkSms = '1';
                $file = $filePath;
                if ($data['smsType'] == 'bulk_sms') {
                    if (!empty($data['fileName'])) {           
                        $excel = Excel::load($file)->all()->toArray();
                        $count = 0;
                        $mobileNumArray = array();
                        for ($i=0; $i < count($excel); $i++)
                        {
                            $num =  $excel[$i]['phone'] ;
                            if ($num != "") {
                                if (is_numeric($num)) {
                                    $mobileNumArray[] = $num;
                                    $count++;
                                }
                            }
                            if (!is_numeric($num)) {
                                $validFile = false;
                                $result = ["success" => false, "status" => 509, "message" => "Unable to process request, Invalid file or file not readable."];
                                return json_encode($result);
                            }
                        }
                        if ($count > 50000){
                            $result = ["success" => false, "status" => 412, "message" => "Request maximum 50,000 mobile number\'s in excel sheet."];
                            return json_encode($result);
                        }
                        
                    } else {
                        $result = ["success" => false, "status" => 404, "message" => "File not found, Please try again."];
                        return json_encode($result);
                    }
                } elseif ($data['smsType'] == 'customer_sms') {
                    $mobileNumArray = json_decode($_SESSION['customer_mobile_numbers'], true);
                }
                if (!empty($file)) {
                    $clientData = SystemConfig::select('client_id')->where(['id' => 1])->get(); //get client id
                     
                    $clientId = $clientData[0]['client_id'];
                    $clientType = '';
                    $smsType = "P_SMS";                    
                    $folder = 'bulk_sms';
                    
                    $postData = ["method" => "xlsUpload", 
                        "userid" => "2000161554", 
                        "password" => "Nextedge@2016#", 
                        "filetype" => "xls",                         
                        "v" => "1.1", 
                        "auth_scheme" => "PLAIN",
                        "xlsFile" => new \CURLFile($file), 
                        "msg_type" => $msgType, 
                        "msg" => urlencode($smsBody), 
                    ];
                    /*****************************************************************************
                    $ch = curl_init();
                    $timeout = 60;
                    curl_setopt($ch, CURLOPT_URL, "http://enterprise.smsgupshup.com/GatewayAPI/rest");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    $data = curl_exec($ch);
                    if ($data === FALSE) {
                        throw new Exception(curl_errno($ch));
                    }
                    curl_close($ch);
                    /*****************************************************************************/

                    $matches = [];
                    $data = "success | Your file is being processed. Transaction id 3271981124384453997. Please refer upload history below for final status.";
                    $data = explode(" | ", $data);
                    if ($data[0] == 'success') {
                        $status = $data[0];
                        $found = preg_match('/ id ([^-\s]*)/', $data[1], $matches);
                        $externalId1 = rtrim($matches[1],'.');
                        $externalId2 = '';
                        $totalChar = strlen($smsBody);
                        $smsBody = addslashes($smsBody);
                        $smsBody = addslashes($smsBody);

                        $j = 1;
                        if ($totalChar > 160)
                            $j = 2;
                        if ($totalChar > 320)
                            $j = 3;
                        $creditsDeducted = $j;

                        if ($sendingType == 2)
                            $creditsDeducted = $j * 2;
                        $splitMobileNumber = array_chunk($mobileNumArray, 3000);
                        
                        $deliveredTS = $deliveredStatus = $cause = $requestUrl = $logStatus = "";
                        $sms_sending_type = $isInternational = 0;
                        foreach ($splitMobileNumber as $mobileNumber) {
                            foreach ($mobileNumber as $list) {
                                $mNumber = str_replace(" ", "", $list);
                                $externalId1 = trim($externalId1);
                                $date = date("Y-m-d H:i:s");
                                $input[] = ["employee_id" => $loggedInUserId, "sent_date_time" => $date, "client_id" => $clientId, "client_type" => "$clientType", "externalId1" => "$externalId1", 
                                    "externalId2" => "$externalId2", "deliveredTS" => "$deliveredTS", "mobile_number" => "$mNumber", "sms_body" => $smsBody, "customer_sms" => "$customer", 
                                    "customer_id" => $customerId, "bulk_sms" => "$bulkSms", "bulk_file_id" => "$filePath", "sms_type" => "$smsType", "sms_sending_type" => $sms_sending_type, "status" => $status, 
                                    "delivered_status" => $deliveredStatus, "cause" => "$cause", "request_url" => $requestUrl, "log_status" => $logStatus, 
                                    "credits_deducted" => $creditsDeducted, "is_international" => $isInternational];   
                            }
                            $insertSmsLog = Gupshup::smslog($input);
                            
                            /*if ($insertSmsLog == 1) {
                                $sql = "INSERT INTO smsgupshup_realtimereport "
                                        . "(am_uid, sent_date_time, client_id, "
                                        . "client_type, externalId1, externalId2, "
                                        . "deliveredTS, mobile_number, sms_body, "
                                        . "customer_sms, customer_id, bulk_sms, "
                                        . "bulk_file_id, sms_type,sms_sending_type, "
                                        . "status, delivered_status, cause, "
                                        . "request_url, log_status,credits_deducted) "
                                        . "values ";
                                $sql .= @implode(',', $valuesArr);
                                $bulkSms = '1';
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_URL => "http://edynamics.co.in/office.php/realtimereport/smsLog?",
                                    CURLOPT_USERAGENT => 'cURL Request',
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => array(
                                        sql => $sql,
                                        bulk_sms => $bulkSms),
                                ));
                                // Send the request & save response to $resp
                                $resp = curl_exec($curl);
                                // Close request to clear up some resources
                                curl_close($curl);
                            }*/
                        }
                        /*if (Yii::app()->s3->awsupload($file, $folder, $fileName)) { // push excel to s3 bucket
                            @unlink($file);
                        }*/
                        $result = ["success" => true, "status" => 200, "message" => "SMS sent successfully"];
                        return json_encode($result);
                    } else {
                        $result = ["success" => false, "status" => 404, "message" => "Unable to process request, Please try again after one hour."];
                        return json_encode($result);
                    }
                } else {
                    $result = ["success" => false, "status" => 404, "message" => "File not found, Please try again."];
                    return json_encode($result);
                }
            } else {
                $result = ["success" => true, "status" => 401, "message" => "Account is deactivated or suspended"];
                return json_encode($result);
            }

            if (Yii::app()->s3->awsupload($file, $folder, $filePath)) { // push excel to s3 bucket
                @unlink($file);
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
    }

    public static function smslog($input) {
        if (!empty($input)) {
            SmsLog::insert($input); //create log
            return TRUE;
        } else {
            return FALSE;
        }
    }    
}
