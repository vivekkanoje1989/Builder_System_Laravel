<?php
$GLOBALS['server_name'] = "";
$config = ltrim($_SERVER['HTTP_HOST'], "www.") . '.php';
$path = '../dbcredentials/' . $config;
include ($path);

$GLOBALS['uname'] = $uname;
$GLOBALS['password'] = $password;
$GLOBALS['dbname'] = $dbname;
$GLOBALS['server'] = $server_name;
session_start();
$domain = ltrim($_SERVER['HTTP_HOST'], "www.");
//print_r($domain['client_info']);exit;
if (empty($_SESSION[$domain]['client_info']) || empty($_SESSION[$domain]['aws_bucket_id'])) {
    $connetion = mysqli_connect("$server_name", "$uname", "$password");
    if (!$connetion) {
       echo "<div style='text-align: center;margin-top: 100px;font-size: 35px;color: red;'>
                $server_name == $uname == $password
                A database connection could not be established. Please try again.
            </div>";
        exit;
    } else {
        mysqli_select_db($connetion, $dbname);
        $sql = "SELECT *  FROM `client_informations` WHERE `id` = 1";
        $result = mysqli_query($connetion, $sql);
        $result_row = mysqli_fetch_assoc($result);
        $GLOBALS['client_info'] = json_encode($result_row);

        $GLOBALS['client_id'] = $result_row['master_client_id'];
        $GLOBALS['brand_id'] = $result_row['brand_id'];
        $_SESSION[$domain]['client_info'] = $result_row;
        $_SESSION[$domain]['client_id'] = $result_row['master_client_id'];
        $_SESSION[$domain]['brand_id'] = $result_row['brand_id'];
        
        $system_info_sql = "SELECT *  FROM `system_configs` WHERE `id` = 1";
        $system_result = mysqli_query($connetion, $system_info_sql);
        $system_row = mysqli_fetch_assoc($system_result);
        $GLOBALS['aws_bucket_id'] = $system_row['aws_bucket_id'];
        $_SESSION[$domain]['aws_bucket_id'] = $system_row['aws_bucket_id'];
    }
}
else
{
    $GLOBALS['client_info'] = json_encode($_SESSION[$domain]['client_info']);
    $GLOBALS['client_id']= $_SESSION[$domain]['client_id'];
    $GLOBALS['brand_id']= $_SESSION[$domain]['brand_id'];
    $GLOBALS['aws_bucket_id'] = $_SESSION[$domain]['aws_bucket_id'];    
}
/*
  |--------------------------------------------------------------------------
  | Register The Auto Loader
  |--------------------------------------------------------------------------
  |
  | Composer provides a convenient, automatically generated class loader for
  | our application. We just need to utilize it! We'll simply require it
  | into the script here so that we don't have to worry about manual
  | loading any of our classes later on. It feels nice to relax.
  |
 */

require __DIR__ . '/../bootstrap/autoload.php';

/*
  |--------------------------------------------------------------------------
  | Turn On The Lights
  |--------------------------------------------------------------------------
  |
  | We need to illuminate PHP development, so let us turn on the lights.
  | This bootstraps the framework and gets it ready for use, then it
  | will load up this application so that we can run it and send
  | the responses back to the browser and delight our users.
  |
 */

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
  |--------------------------------------------------------------------------
  | Run The Application
  |--------------------------------------------------------------------------
  |
  | Once we have the application, we can handle the incoming request
  | through the kernel, and send the associated response back to
  | the client's browser allowing them to enjoy the creative
  | and wonderful application we have prepared for them.
  |
 */

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
