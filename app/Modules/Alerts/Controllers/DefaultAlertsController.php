<?php namespace App\Modules\Alerts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\TemplatesDefault;
use App\Models\TemplatesDefaultsLogs;
use App\Models\TemplatesCustom;
use App\Models\backend\Employee;
class DefaultAlertsController extends Controller {
	public function index()
	{
		return view("Alerts::defaultalertsindex");
	}
    public function store()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $create = CommonFunctions::insertMainTableRecords();
        $request['defaultAlertData'] = array_merge($request['defaultAlertData'],$create);
        //echo "<pre>";print_r($request['defaultAlertData']);die;
        $result = TemplatesDefault::create($request['defaultAlertData']);
        if($result){
            $result = ['success' => true, 'message' => 'Dafault alerts created successfully.'];
        }
        else{
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
        }
        echo json_encode($result);
    }
	public function edit($id)
	{
		return view("Alerts::defaultalertscreate")->with(array('alertId' => $id));
	}
    public function create()
    {
        return view("Alerts::defaultalertscreate");
    }
	public function update($id)
	{
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $result = ['success' => true, 'records' => $request];
        echo json_encode($result);
	}
    public function updateDefaultAlerts() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['defaultAlertData']['updated_date'] = date('Y-m-d');
        $request['defaultAlertData']['updated_by'] = Auth::guard('admin')->user()->id;
        $request['defaultAlertData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $request['defaultAlertData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $request['defaultAlertData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        unset($request['defaultAlertData']['event_name']);
        unset($request['defaultAlertData']['module_names']);
        $originalValues = TemplatesDefault::where('id', $request['id'])->get();
        $CustomAlertUpdate=TemplatesDefault::where('id',$request['id'])->update($request['defaultAlertData']);
        $last = TemplatesDefaultsLogs::latest('id')->first();
        $getResult = array_diff_assoc($originalValues[0]['attributes'],$request['defaultAlertData']);
        $implodeArr =  implode(",",array_keys($getResult));
        $result =  DB::table('templates_defaults_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
        $data = ['success' => true, 'message' => 'Default alerts updated succesfully'];
        return json_encode($data);
       
    }
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function manageDafaultAlerts(){
		$postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageAlerts = [];
        
        if(!empty($request['id']) && $request['id'] !== "0"){ // for edit
            $manageAlerts = DB::table('templates_defaults as td')
           ->leftjoin('templates_events as te', 'td.templates_event_id', '=', 'te.id')
           ->select('td.*', 'te.event_name','te.module_names')
           ->where('td.id','=',$request['id'])
           ->get();
        } else if($request['id'] === ""){ // for index
        $manageAlerts = DB::table('templates_defaults as td')
           ->leftjoin('templates_events as te', 'td.templates_event_id', '=', 'te.id')
           ->select('td.*', 'te.event_name','te.module_names')
           ->get();
           /*->leftjoin(DB::raw('(SELECT login_date_time,employee_id FROM employees_login_logs ORDER BY id DESC limit 1) AS employees_login_logs'), 'employees.id', '=', 'employees_login_logs.employee_id')*/
        }
        if ($manageAlerts) {            
            $result = ['success' => true, "records" => ["data" => $manageAlerts, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
            echo json_encode($result);
        } 
	}
}
