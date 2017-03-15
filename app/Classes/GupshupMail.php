<?php
namespace App\Classes;

use Auth;
use App\Models\Credit;
use App\Models\EmailPassword;
use App\Models\SystemConfig;
use App\Models\EmailLog;
use DB;
use App\Mail\MailConfig;
use Maatwebsite\Excel\Facades\Excel;

class Gupshup {

    public function sendMail($data, $loggedInUserId, $fileAttach) {
        try {
            if (!empty($data['to'])) {
                $from_date = date("Y-m-d 00:00:00", strtotime("first day of this month"));
                $to_date = date("Y-m-d 23:59:59", strtotime("last day of this month"));

                $logs = EmailLog::selectRaw("sum(*)")->whereBetween('sent_date_time', array($fromDate, $toDate))->first();
                $emailconsume = $logs[0]['count(*)'];

                $totalEmailCredits = Credit::select('email_credit_limit', 'email_status')->where(['id' => 1])->get();

                if ($totalEmailCredits->email_status == '1') {
                    if ($totalEmailCredits->email_credit_limit > $emailconsume) {

                        $emailApi = EmailPassword::select('email_id', 'email_pwd')->where(['id' => 3])->get(); //sms credentials
                        $clientData = SystemConfig::select('client_id')->where(['id' => 1])->get(); //get client id

                        $fromEmailId = $data['from_email_id'];
                        $clientId = $clientData->client_id;
                        $customer = $mailType = "NO";
                        $customerId = $clientType = "";

                        $targetUrl = 'http://enterprise.webaroo.com/GatewayAPI/rest';
                        if (!empty($data['newsletterfile_name'])) {
                            if (!empty($fileAttach)) {
                                $cnt = count($fileAttach['name']);
                                for ($i = 0; $i < $cnt; $i++) {
                                    $key = 'attachment' . ($i + 1);
                                    $value = new CurlFile($fileAttach['tempname'][$i], 'text/html', $fileAttach['name'][$i]);
                                    $arr1[] = $key;
                                    $arr2[] = $value;
                                }
                                $arr = array_combine($arr1, $arr2);
                                $post1 = array(
                                    'method' => 'EMS_UPLOAD_CAMPAIGN',
                                    'userid' => $emailApi->email_id,
                                    'password' => $this->$emailApi->email_pwd,
                                    'v' => '1.1',
                                    'name' => $data['from_name'],
                                    'recipients' => $data['to'],
                                    'subject' => $data['subject'],
                                    'newsletter_file' => new CurlFile($data['newsletterfile_path'], 'text/html', $data['newsletterfile_name']),
                                    'content_type' => 'text/html',
                                    'format' => 'json'
                                );
                                $post = array_merge($post1, $arr);
                            } else {
                                $post = array(
                                    'method' => 'EMS_UPLOAD_CAMPAIGN',
                                    'userid' => $emailApi->email_id,
                                    'password' => $this->$emailApi->email_pwd,
                                    'v' => '1.1',
                                    'name' => $data['from_name'],
                                    'recipients' => $data['to'],
                                    'subject' => $data['subject'],
                                    'newsletter_file' => new CurlFile($data['newsletterfile_path'], 'text/html', $data['newsletterfile_name']),
                                    'content_type' => 'text/html',
                                    'format' => 'json'
                                );
                            }
                        } else {
                            if (!empty($fileAttach)) {
                                $cnt = count($fileAttach['name']);
                                for ($i = 0; $i < $cnt; $i++) {
                                    $key = 'attachment' . ($i + 1);
                                    $value = new CurlFile($fileAttach['tempname'][$i], 'text/html', $fileAttach['name'][$i]);
                                    $arr1[] = $key;
                                    $arr2[] = $value;
                                }
                                $arr = array_combine($arr1, $arr2);
                                $post2 = array(
                                    'method' => 'EMS_POST_CAMPAIGN',
                                    'userid' => $emailApi->email_id,
                                    'password' => $this->$emailApi->email_pwd,
                                    'v' => '1.1',
                                    'name' => $data['from_name'],
                                    'recipients' => $data['to'],
                                    'subject' => $data['subject'],
                                    'content' => $data['body'],
                                    'content_type' => 'text/html',
                                    'format' => 'json'
                                );
                                $post = array_merge($post2, $arr);
                            } else {
                                $post = array(
                                    'method' => 'EMS_POST_CAMPAIGN',
                                    'userid' => $emailApi->email_id,
                                    'password' => $this->$emailApi->email_pwd,
                                    'v' => '1.1',
                                    'name' => $data['from_name'],
                                    'recipients' => $data['to'],
                                    'subject' => $data['subject'],
                                    'content' => $data['body'],
                                    'content_type' => 'text/html',
                                    'format' => 'json'
                                );
                            }
                        }

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $targetUrl);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_VERBOSE, 0);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $res = curl_exec($ch);
                        $response = json_decode($res, true);
                        curl_close($ch);

                        if ($response['response']['status'] === "success") {
                            $externalId1 = $response['response']['id'];
                            $status = $response['response']['status'];
                            $date = date("Y-m-d H:i:s");
                            $bulkEmail = 0;
                            $bulk_file_id = "No";
                            $credits_deducted = $logStatus = 1;
                            $requestUrl = "";

                            $email_no_arr = @explode(',', $data['to']);

                            $replace_email_body = str_replace('"', "'", $data['body']);

                            foreach ($mobileNoArr as $num) {
                                $input[] = ["employee_id" => $loggedInUserId, "client_id" => $clientId, "client_type" => "$clientType",
                                    "externalId1" => "$externalId1", "sent_date_time" => "$date", "mail_id" => "$email", "mail_body" => "$replace_email_body",
                                    "customer_mail " => "$customer", "customer_id" => $customerId, "bulk_email" => "$bulkEmail", "bulk_file_id" => "$file_name",
                                    "mail_type" => "$mailType", "status" => $status, "credits_deducted" => $credits_deducted,
                                    "api_username" => "$emailApi->email_id", "request_url" => $requestUrl, "log_status" => $logStatus];
                            }
                            $insertEmailLog = Gupshup::emailLog($input);

                            /* foreach ($email_no_arr as $email) {
                              $valuesArr[] = '("' . $user_id . '","' . $clientId . '","' . $clientType . '","' . $externalId1 . '","' . $date . '","' . $email . '","' . $replace_email_body . '","' . $customer . '","' . $customerId . '","' . $bulk_mail . '","' .
                              $file_name . '","' . $mailType . '","' . $status . '","' . $credits_deducted . '","' . $emailApi->email_id . '","' . $request_url . '","' . $log_status . '")';
                              }
                              $sql = "INSERT INTO email_log (am_uid, client_id, client_type, externalId1, sent_date_time, mail_id, mail_body, customer_mail, customer_id, bulk_mail, bulk_file_id, mail_type, status, credits_deducted, api_username, request_url, log_status) values ";
                              $sql .= implode(',', $valuesArr);
                              $result = $this->emaillog($sql); */


                            if ($result == 1) {

                                $sql = "INSERT INTO email_log (am_uid, client_id, client_type, externalId1, sent_date_time, mail_id, mail_body, customer_mail, customer_id, bulk_mail, bulk_file_id, mail_type, status, credits_deducted, api_username, request_url, log_status) values ";
                                $sql .= implode(',', $valuesArr);
                                $curl = curl_init();
                                // Set some options - we are passing in a useragent too here
                                curl_setopt_array($curl, array(
                                    CURLOPT_RETURNTRANSFER => true,
                                    // CURLOPT_URL => "http://edynamics.co.in/office.php/realtimereport/emailLog?",
                                    CURLOPT_URL => "http://balaji/edynamicsown/office.php/realtimereport/emailLog?",
                                    CURLOPT_USERAGENT => 'cURL Request',
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => array(
                                        sql => $sql,
                                    )
                                ));
                                // Send the request & save response to $resp
                                $resp = curl_exec($curl);
                                // Close request to clear up some resources
                                curl_close($curl);
                                if ($resp == 1) {
                                    return TRUE;
                                }
                            }
                            return 'Status 101 - Email sent sucessfully';
                        } else {
                            echo 'Email  Not Sent!';
                            return FALSE;
                        }
                    } else {

                        $username = 'sales@edynamics.co.in';
                        $pass = 'Ed2016sales#';
                        $from = $username;
                        $from_name = COMPANY_NAME;

                        $mail = new PHPMailer(); // create a new object			
                        $mail->IsSMTP(); // enable SMTP
                        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                        $mail->SMTPAuth = true; // authentication enabled
                        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                        $mail->Host = "smtp.gmail.com";
                        $mail->domain = "gmail.com";
                        $mail->authentication = "plain";
                        $mail->Port = 465; // or 587 465
                        $mail->IsHTML(true);
                        $mail->Username = $username;
                        $mail->Password = $pass;
                        $mail->Subject = 'Insufficient Email Credit Limit';
                        $mail->Body = 'Your Email creadit limit exceeded , So Please contact to BMS Administrator.' . '<br><br>' . 'Thank You!';
                        $mail->SetFrom($from, $from_name);
                        $mail->AddAddress('balaji@edynamics.co.in');
                        if ($mail->Send()) {
                            echo 'Insufficient creadit Limit';
                        }

                        return '104 - Credit Limit exceeded please contact to BMS admin.';
                    }
                } else {
                    echo 'Account Is Deactivated';
                    return FALSE;
                }
            }
        } catch (Exception $ex) {
            
        }
    }

    public static function emailLog($input) {
        if (!empty($input)) {
            EmailLog::insert($input); //create log
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
?>