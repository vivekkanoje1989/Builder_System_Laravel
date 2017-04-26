<?php
/**
 * Use a Gupshup Enterprise account to send messages.
 * Supports setting time and mask for individual messages.
 *
 * @author Anshul <anshula@webaroo.com>
 */
class EnterpriseSender{
 public $id;
 public $password; 
 
 /**
 * Mask that would appear on receiver’s phone. For what can appear here,
 * contact SMS GupShup Support as the mask needs to be set in the account
 * before it can be used here.
 * @var String
 */
 public $mask;
 private $_url = "http://enterprise.smsgupshup.com/GatewayAPI/rest";
 private $_messages = array();
 public function __construct($id, $password, $mask = NULL) {
 $this->id = $id;
 $this->password = $password;
 $this->mask = $mask;
 }
 /**
 *
 * @param String $msisdn MSISDN of the recipient (will include 91)
 * @param String $content Message content
 * @param String $mask One of the mask as set in the enterprise account
 * @param String $time In any acceptable format for PHP. Time Zone assumed to be
IST.
 * @return Boolean
 */
 public function addMsg($msisdn, $content, $mask = NULL, $time = "now"){
 $message = new stdClass();
 $message->msisdn = $msisdn;
 $message->content = $content;
 $message->mask = $mask == NULL ? $this->mask : $mask;
 $message->time = new DateTime($time, new DateTimeZone("Asia/Kolkata"));
 $this->_messages[] = $message;
 return TRUE;
 }
 /**
 * Sends the response using file upload API
 * @return Boolean
 */
 public function sendMsg(){
 $rows = array();
 foreach ($this->_messages as $message) {
 $rows[] = array(
 $message->msisdn,
 $message->content,
 $message->mask,
 $message->time->format('Y-m-d H:i:s')
 );
 }
 $fileName = tempnam(sys_get_temp_dir(), 'EnterpriseUpload').'.csv';
 $myFile = fopen($fileName, 'w');
 fputs($myFile,
 '"'
 .implode('","', array(
 'PHONE',
 'MESSAGE',
 'MASKS',
 'TIMESTAMPS'
 ))
 .'"'
 ."\n"
 );
 foreach ($rows as $row) { 
 
 fputcsv($myFile, $row, ',', '"');
 }
 fclose($myFile);
 $params = array();
 $params['method'] = 'xlsUpload';
 $params['userid'] = $this->id;
 $params['password'] = $this->password;
 $params['filetype'] = 'csv';
 $params['auth_scheme'] = 'PLAIN';
 $params['v'] = '1.1';
 $params['xlsFile'] = '@'.realpath($fileName);
 $response = self::post($this->_url, $params, TRUE, CURL_HTTP_VERSION_1_0);
 unlink($fileName);
 return preg_match('/^success/', $response);
 }
 public static function post($url, $params, $multipart = FALSE, $version=
CURL_HTTP_VERSION_NONE){
 if(function_exists('curl_init')){
 $ch = curl_init();
 $timeout = 60;
 curl_setopt($ch,CURLOPT_URL,$url);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 curl_setopt($ch, CURLOPT_HTTP_VERSION, $version);
 curl_setopt($ch, CURLOPT_POST, TRUE);
 if($multipart){
 curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
 }else{
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
 }
 curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
 $data = curl_exec($ch);
 if($data === FALSE){
 throw new Exception(curl_errno($ch));
 }
 curl_close($ch);
 return $data;
 }else{
 return FALSE;
 }
 }
}
?> 