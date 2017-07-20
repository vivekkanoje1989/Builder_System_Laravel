<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Classes\CommonFunctions;
/**
 * Class CtSetting
 * 
 * @property int $id
 * @property int $ct_billing_settings_id
 * @property int $client_id
 * @property int $virtual_number
 * @property bool $default_number
 * @property bool $menu_status
 * @property int $ivr_type_id
 * @property int $welcome_tune_type_id
 * @property string $welcome_tune
 * @property int $hold_tune_type_id
 * @property string $hold_tune
 * @property int $forwarding_type_id
 * @property int $forwarding_time
 * @property string $employees
 * @property int $source_id
 * @property int $sub_source_id
 * @property string $source_disc
 * @property int $model_project_id
 * @property bool $insert_enquiry
 * @property bool $missed_call_insert_enquiry
 * @property bool $ec_call_status
 * @property int $ec_welcome_tune_type_id
 * @property string $ec_welcome_tune
 * @property int $ec_hold_tune_type_id
 * @property string $ec_hold_tune
 * @property bool $alert_to_enq_owner
 * @property bool $open_enquiry_owner_emp_action
 * @property bool $open_enquiry_other_emp_action
 * @property bool $lost_enquiry_owner_emp_action
 * @property bool $lost_enquiry_other_emp_action
 * @property bool $read_cust_name
 * @property bool $read_emp_name

 * @property int $nwh_status
 * @property \Carbon\Carbon $nwh_start_time
 * @property \Carbon\Carbon $nwh_end_time
 * @property int $nwh_welcome_tune_type_id
 * @property string $nwh_welcome_tune
 * @property int $nwh_call_insert_enquiry
 * @property bool $msc_employee_type
 * @property int $msc_default_employee_id
 * @property bool $msc_facility_status
 * @property int $msc_welcome_tune_type_id
 * @property string $msc_welcome_tune
 * @property int $created_by
 * @property \Carbon\Carbon $created_date
 * @property int $updated_by
 * @property \Carbon\Carbon $updated_date
 * @property bool $inbound_call_status
 * @property bool $outbound_call_status
 *
 * @package App\Models
 */
class CtSetting extends Eloquent
{
	public $timestamps = false;
        
        public $step = 1;

        protected $casts = [
		'ct_billing_settings_id' => 'int',
		'client_id' => 'int',
		'virtual_number' => 'int',
		'default_number' => 'bool',
		'menu_status' => 'bool',
		'ivr_type_id' => 'int',
		'welcome_tune_type_id' => 'int',
		'hold_tune_type_id' => 'int',
		'forwarding_type_id' => 'int',
		'forwarding_time' => 'int',
		'source_id' => 'int',
		'sub_source_id' => 'int',
		'model_project_id' => 'int',
		'insert_enquiry' => 'bool',
		'missed_call_insert_enquiry' => 'bool',
		'ec_call_status' => 'int',
		'ec_welcome_tune_type_id' => 'int',
		'ec_hold_tune_type_id' => 'int',
                'alert_to_enq_owner' => 'int',
                'open_enquiry_owner_emp_action' => 'int',
                'open_enquiry_other_emp_action' => 'int',
                'lost_enquiry_owner_emp_action' => 'int',
                'lost_enquiry_other_emp_action' => 'int',
                'read_cust_name' => 'bool',
                'read_emp_name' => 'bool',
		'nwh_status' => 'int',
		'nwh_welcome_tune_type_id' => 'int',
		'nwh_call_insert_enquiry' => 'int',
		'msc_employee_type' => 'bool',
		'msc_default_employee_id' => 'int',
		'msc_facility_status' => 'bool',
		'msc_welcome_tune_type_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'inbound_call_status' => 'bool',
		'outbound_call_status' => 'bool'
	];

	protected $dates = [
		//'nwh_start_time',
		//'nwh_end_time',
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'ct_billing_settings_id',
		'client_id',
		'virtual_number',
		'default_number',
		'menu_status',
		'ivr_type_id',
		'welcome_tune_type_id',
		'welcome_tune',
		'hold_tune_type_id',
		'hold_tune',
		'forwarding_type_id',
		'forwarding_time',
		'employees',
		'source_id',
		'sub_source_id',
		'source_disc',
		'model_project_id',
		'insert_enquiry',
		'missed_call_insert_enquiry',
		'ec_call_status',
		'ec_welcome_tune_type_id',
		'ec_welcome_tune',
		'ec_hold_tune_type_id',
		'ec_hold_tune',
                'alert_to_enq_owner',
                'open_enquiry_owner_emp_action',
                'open_enquiry_other_emp_action',
                'lost_enquiry_owner_emp_action',
                'lost_enquiry_other_emp_action',
                'read_cust_name',
                'read_emp_name',
		'nwh_status',
		'nwh_start_time',
		'nwh_end_time',
		'nwh_welcome_tune_type_id',
		'nwh_welcome_tune',
		'nwh_call_insert_enquiry',
		'msc_employee_type',
		'msc_default_employee_id',
		'msc_facility_status',
		'msc_welcome_tune_type_id',
		'msc_welcome_tune',
		'created_by',
		'created_date',
		'updated_by',
		'updated_date',
		'inbound_call_status',
		'outbound_call_status'
	];
        
        
    public static function validationMessages(){
        $messages = array(
            //'client_id.required' => 'Please select client',
            'virtual_number' =>['required' => 'Please enter viwelcomertual number', 'numeric' => 'Please enter only digits', 'max' => 'Virtual number must be 12 digits only'],
            'welcome_tune_type_id.required' => 'Please select welcome tune type',
            //'hold_tune_type_id' => 'Please select hold tune type',
            'forwarding_type_id' => 'Please select forwarding type',
            'source_id' => 'Please select source',
            'model_project_id' => 'Please select vehicle model',
        );
        return $messages;
    }
    
    public static function validationRules(){
        $rules = array(
            //'client_id' => 'required|numeric',
            'virtual_number' => 'required|max:12',
            'welcome_tune_type_id' => 'required',
            'forwarding_type_id' => 'required',
            'source_id' => 'required|numeric',
            'model_project_id' => 'required',
        );
        return $rules;
    }
    
    public static function updateStep1($input = array()) {
       
        if(empty($input['default_number']))
            $input['default_number'] = 0;
        if(empty($input['menu_status']))
            $input['menu_status'] = 0;
        
        if($input['menu_status'] == 0)
            $input['ivr_type_id'] = 1;
        else 
            $input['ivr_type_id'] = 2;
        
        if($input['forwarding_type_id'] == 1)
            $input['forwarding_time'] == 0;
        
        if(empty($input['missed_call_insert_enquiry']))
            $input['missed_call_insert_enquiry'] == 0;
        
        $empcount = count($input['employees1']);
        $employees='';
        $j= $empcount - 1;
        for($i=0;$i < $empcount;$i++){
            if($i<$j)
                $employees .= $input['employees1'][$i]['id'].',';
            else
                $employees .= $input['employees1'][$i]['id'];
        }
        
        $affectedRows = CtSetting::where('id', '=', $input['id'])->update([
            'client_id' => $input['client_id'],
            'virtual_number' => $input['virtual_number'],
            'menu_status' => $input['menu_status'],            
            'ivr_type_id' => $input['ivr_type_id'],
            'welcome_tune_type_id' => $input['welcome_tune_type_id'],
            'welcome_tune' => $input['welcome_tune'],
            'hold_tune_type_id' => $input['hold_tune_type_id'],
            'hold_tune' => $input['hold_tune'],
            'forwarding_type_id' => $input['forwarding_type_id'],
            'forwarding_time' => $input['forwarding_time'],
            'source_id' => $input['source_id'],
            'sub_source_id' => $input['sub_source_id'],
            'source_disc' => $input['source_disc'],
            'model_project_id' => $input['model_project_id'],
            'insert_enquiry' => $input['insert_enquiry'],
            'missed_call_insert_enquiry' => $input['missed_call_insert_enquiry'],
            'msc_default_employee_id' => $input['msc_default_employee_id'][0]['id'],
            'nwh_status' => $input['nwh_status'],
            'nwh_start_time' => date('H:i:s',strtotime($input['nwh_start_time'])),
            'nwh_end_time' => date('H:i:s',strtotime($input['nwh_end_time'])),
            'nwh_welcome_tune_type_id' => $input['nwh_welcome_tune_type_id'],
            'nwh_welcome_tune' => $input['nwh_welcome_tune'],
            'nwh_call_insert_enquiry' => $input['nwh_call_insert_enquiry'],
            'employees' => $employees,
            'updated_by' => Auth()->guard('admin')->user()->id,
            'updated_date' => date('Y-m-d H:i:s'),
            
            ]);
            CtSetting::ctsettingslogs($input);
        return true;
        
    }
    
    
    public static function updateStep2($input = array()) {
        $affectedRows = CtSetting::where('id', '=', $input['id'])->update([
            'ec_call_status' => $input['ec_call_status'],
            'ec_welcome_tune_type_id' => $input['ec_welcome_tune_type_id'],
            'ec_welcome_tune' => $input['ec_welcome_tune'],
            'ec_hold_tune_type_id' => $input['ec_hold_tune_type_id'],
            'ec_hold_tune' => $input['ec_hold_tune'],
            'alert_to_enq_owner' => $input['alert_to_enq_owner'],
            'open_enquiry_owner_emp_action' => $input['open_enquiry_owner_emp_action'],
            'open_enquiry_other_emp_action' => $input['open_enquiry_other_emp_action'],
            'lost_enquiry_owner_emp_action' => $input['lost_enquiry_owner_emp_action'],
            'lost_enquiry_other_emp_action' => $input['lost_enquiry_other_emp_action'],
            'updated_by' => Auth()->guard('admin')->user()->id,
            'updated_date' => date('Y-m-d H:i:s'),
            
            ]);
            CtSetting::ctsettingslogs2($input);
        return true;
        
    }
    
     public static function ctsettingslogs($input = array()) {
        
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d H:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        //$ip = $_SERVER['REMOTE_ADDR'];
        //$data = \Location::get("175.100.138.136");
        
        if(empty($input['default_number']))
            $input['default_number'] = 0;
        if(empty($input['menu_status']))
            $input['menu_status'] = 0;
        
        if($input['menu_status'] == 0)
            $input['ivr_type_id'] = 1;
        else 
            $input['ivr_type_id'] = 2;
        
        if($input['forwarding_type_id'] == 1)
            $input['forwarding_time'] == 0;
        
        if(empty($input['missed_call_insert_enquiry']))
            $input['missed_call_insert_enquiry'] == 0;
        
        $empcount = count($input['employees1']);
        $employees='';
        $j= $empcount - 1;
        for($i=0;$i < $empcount;$i++){
            if($i<$j)
                $employees .= $input['employees1'][$i]['id'].',';
            else
                $employees .= $input['employees1'][$i]['id'];
        }
        
        $stime = date('H:i:s',strtotime($input['nwh_start_time']));
        $etime = date('H:i:s',strtotime($input['nwh_end_time']));
        //echo $stime.' => '.$etime;exit;
        CtSettingsLog::create([
            'main_record_id' => $input['id'],
            'client_id' => $input['client_id'],
            'ct_billing_settings_id' => $input['ct_billing_settings_id'],
            'virtual_number' => $input['virtual_number'],
            'menu_status' => $input['menu_status'],            
            'ivr_type_id' => $input['ivr_type_id'],
            'welcome_tune_type_id' => $input['welcome_tune_type_id'],
            'welcome_tune' => $input['welcome_tune'],
            'hold_tune_type_id' => $input['hold_tune_type_id'],
            'hold_tune' => $input['hold_tune'],
            'forwarding_type_id' => $input['forwarding_type_id'],
            'forwarding_time' => $input['forwarding_time'],
            'source_id' => $input['source_id'],
            'sub_source_id' => $input['sub_source_id'],
            'source_disc' => $input['source_disc'],
            'model_project_id' => $input['model_project_id'],
            'insert_enquiry' => $input['insert_enquiry'],
            'missed_call_insert_enquiry' => $input['missed_call_insert_enquiry'],
            'msc_default_employee_id' => $input['msc_default_employee_id'][0]['id'],
            'employees' => $employees,
            'ec_call_status' => $input['ec_call_status'],
            'ec_welcome_tune_type_id' => $input['ec_welcome_tune_type_id'],
            'ec_welcome_tune' => $input['ec_welcome_tune'],
            'ec_hold_tune_type_id' => $input['ec_hold_tune_type_id'],
            'ec_hold_tune' => $input['ec_hold_tune'],
            'nwh_status' => $input['nwh_status'],
            'nwh_start_time' => $stime,
            'nwh_end_time' => $etime,
            'nwh_welcome_tune_type_id' => $input['nwh_welcome_tune_type_id'],
            'nwh_welcome_tune' => $input['nwh_welcome_tune'],
            'nwh_call_insert_enquiry' => $input['nwh_call_insert_enquiry'],
            'msc_employee_type' => $input['msc_employee_type'],

            'msc_facility_status' => $input['msc_facility_status'],
            'msc_welcome_tune_type_id' => $input['msc_welcome_tune_type_id'],
            'msc_welcome_tune' => $input['msc_welcome_tune'],
            'inbound_call_status' => $input['inbound_call_status'],
            'outbound_call_status' => $input['outbound_call_status'],
            
            'created_by' => Auth()->guard('admin')->user()->id, 
            'created_date' => date('Y-m-d'),
            'created_IP' => $loginIP,
            'created_browser' => $loginBrowser,
            'created_mac_id' => $loginMacId,
            'record_type' => 1,
            'record_restore_status' => 1
        ]);
    }
    
    public static function ctsettingslogs2($input = array()) {
        
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d H:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        
        $stime = date('H:i:s',strtotime($input['nwh_start_time']));
        $etime = date('H:i:s',strtotime($input['nwh_end_time']));
        //echo $stime.' => '.$etime;exit;
        CtSettingsLog::create([
            'main_record_id' => $input['id'],
            'client_id' => $input['client_id'],
            'ct_billing_settings_id' => $input['ct_billing_settings_id'],
            'virtual_number' => $input['virtual_number'],
            'menu_status' => $input['menu_status'],            
            'ivr_type_id' => $input['ivr_type_id'],
            'welcome_tune_type_id' => $input['welcome_tune_type_id'],
            'welcome_tune' => $input['welcome_tune'],
            'hold_tune_type_id' => $input['hold_tune_type_id'],
            'hold_tune' => $input['hold_tune'],
            'forwarding_type_id' => $input['forwarding_type_id'],
            'forwarding_time' => $input['forwarding_time'],
            'source_id' => $input['source_id'],
            'sub_source_id' => $input['sub_source_id'],
            'source_disc' => $input['source_disc'],
            'model_project_id' => $input['model_project_id'],
            'insert_enquiry' => $input['insert_enquiry'],
            'missed_call_insert_enquiry' => $input['missed_call_insert_enquiry'],
            'msc_default_employee_id' => $input['msc_default_employee_id'],
            'employees' => $input['employees'],
            'ec_call_status' => $input['ec_call_status'],
            'ec_welcome_tune_type_id' => $input['ec_welcome_tune_type_id'],
            'ec_welcome_tune' => $input['ec_welcome_tune'],
            'ec_hold_tune_type_id' => $input['ec_hold_tune_type_id'],
            'ec_hold_tune' => $input['ec_hold_tune'],
            'nwh_status' => $input['nwh_status'],
            'nwh_start_time' => $stime,
            'nwh_end_time' => $etime,
            'nwh_welcome_tune_type_id' => $input['nwh_welcome_tune_type_id'],
            'nwh_welcome_tune' => $input['nwh_welcome_tune'],
            'nwh_call_insert_enquiry' => $input['nwh_call_insert_enquiry'],
            'msc_employee_type' => $input['msc_employee_type'],

            'msc_facility_status' => $input['msc_facility_status'],
            'msc_welcome_tune_type_id' => $input['msc_welcome_tune_type_id'],
            'msc_welcome_tune' => $input['msc_welcome_tune'],
            'inbound_call_status' => $input['inbound_call_status'],
            'outbound_call_status' => $input['outbound_call_status'],
            
            'created_by' => Auth()->guard('admin')->user()->id, 
            'created_date' => date('Y-m-d'),
            'created_IP' => $loginIP,
            'created_browser' => $loginBrowser,
            'created_mac_id' => $loginMacId,
            'record_type' => 1,
            'record_restore_status' => 1
        ]);
    }
}
