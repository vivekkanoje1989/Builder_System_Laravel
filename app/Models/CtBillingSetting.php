<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Classes\CommonFunctions;
/**
 * Class CtBillingSetting
 * 
 * @property int $id
 * @property int $client_id
 * @property string $virtual_number
 * @property bool $default_number
 * @property bool $incoming_call_status
 * @property int $incoming_pulse_duration
 * @property int $incoming_pulse_rate
 * @property bool $outbound_call_status
 * @property int $outbound_pulse_duration
 * @property int $outbound_pulse_rate
 * @property \Carbon\Carbon $activation_date
 * @property int $rent_duration
 * @property int $rent_amount
 * @property \Carbon\Carbon $created_date
 * @property int $created_by
 * @property int $number_status
 * @property \Carbon\Carbon $deactivation_date
 * @property int $deactivated_by
 * @property string $deactivation_reason
 * @property \Carbon\Carbon $updated_date
 * @property int $updated_by
 *
 * @package App\Models
 */
class CtBillingSetting extends Eloquent
{
        
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'default_number' => 'bool',
		'incoming_call_status' => 'bool',
		'incoming_pulse_duration' => 'int',
		'incoming_pulse_rate' => 'int',
		'outbound_call_status' => 'bool',
		'outbound_pulse_duration' => 'int',
		'outbound_pulse_rate' => 'int',
		'rent_duration' => 'int',
		'rent_amount' => 'int',
		'created_by' => 'int',
		'number_status' => 'int',
		'deactivated_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'activation_date',
		'created_date',
		'deactivation_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'virtual_number',
		'default_number',
		'incoming_call_status',
		'incoming_pulse_duration',
		'incoming_pulse_rate',
		'outbound_call_status',
		'outbound_pulse_duration',
		'outbound_pulse_rate',
		'activation_date',
		'rent_duration',
		'rent_amount',
		'created_date',
		'created_by',
		'number_status',
		'deactivation_date',
		'deactivated_by',
		'deactivation_reason',
		'updated_date',
		'updated_by'
	];
        
        public static function validationMessages(){
        $messages = array(
            'client_id.required' => 'Please select client',
            'virtual_number' =>['required' => 'Please enter virtual number', 'numeric' => 'Please enter only digits', 'max' => 'Virtual number must be 10 digits only'],
            'incoming_call_status.required' => 'Please select incoming call status',
            'incoming_pulse_duration.required' => 'Please enter incoming pulse duration',
            'incoming_pulse_rate' => ['required' => 'Please enter incoming pulse rate', 'numeric' => 'Please enter only numeric'],
            'outbound_call_status.required' => 'Please select outbound call status',
            'outbound_pulse_duration.required' => 'Please enter outbound pulse duration',
            'outbound_pulse_rate' => ['required' => 'Please enter outbound pulse rate', 'numeric' => 'Please enter only numeric'],
            'rent_duration.required' => 'Please select rent duration',
            'rent_amount' => ['required' => 'Please enter rent amount', 'numeric' => 'Please enter only numeric'],
            'activation_date.required' => 'Please select activation date'
        );
        return $messages;
    }
        public static function validationRules(){
        $rules = array(
            'client_id' => 'required|numeric',
            'virtual_number' => 'required|max:10',
            'incoming_call_status' => 'required',
            'incoming_pulse_duration' => 'required',
            'incoming_pulse_rate' => 'required|numeric',
            'outbound_call_status' => 'required',
            'outbound_pulse_duration' => 'required',
            'outbound_pulse_rate' => 'required|numeric',
            'rent_duration' => 'required',
            'rent_amount' => 'required|numeric',
            'activation_date' => 'required|date',
        );
        return $rules;
    }
    
    public static function createNumber($input = array()) {
        $affectedRows = new CtBillingSetting();
        
        $affectedRows->client_id = $input['client_id'];
           $affectedRows->virtual_number = $input['virtual_number'];
           $affectedRows->default_number = $input['default_number'];
           $affectedRows->incoming_call_status = $input['incoming_call_status'];            
           $affectedRows->incoming_pulse_duration = $input['incoming_pulse_duration'];
           $affectedRows->incoming_pulse_rate = $input['incoming_pulse_rate'];
           $affectedRows->outbound_call_status = $input['outbound_call_status'];
           $affectedRows->outbound_pulse_duration = $input['outbound_pulse_duration'];
           $affectedRows->outbound_pulse_rate = $input['outbound_pulse_rate'];
           $affectedRows->rent_duration = $input['rent_duration'];
           $affectedRows->rent_amount = $input['rent_amount'];
           $affectedRows->activation_date = date('Y-m-d', strtotime($input['activation_date']));
           $affectedRows->created_by = Auth()->guard('admin')->user()->id;
        
        
        if($affectedRows->save()){
            $input['id'] = $affectedRows->id;
            CtBillingSetting::ctbiillinglogs($input);
            return true;
        }else{
            return false;
        }
        //$this->ctbiillinglogs($input);
        
        
    }
    
    public static function updateNumber($input = array()) {
        $affectedRows = CtBillingSetting::where('id', '=', $input['id'])->update([
            'client_id' => $input['client_id'],
            'virtual_number' => $input['virtual_number'],
            'default_number' => $input['default_number'],
            'incoming_call_status' => $input['incoming_call_status'],            
            'incoming_pulse_duration' => $input['incoming_pulse_duration'],
            'incoming_pulse_rate' => $input['incoming_pulse_rate'],
            'outbound_call_status' => $input['outbound_call_status'],
            'outbound_pulse_duration' => $input['outbound_pulse_duration'],
            'outbound_pulse_rate' => $input['outbound_pulse_rate'],
            'rent_duration' => $input['rent_duration'],
            'rent_amount' => $input['rent_amount'],
            'activation_date' => date('Y-m-d', strtotime($input['activation_date'])),
            'updated_by' => Auth()->guard('admin')->user()->id,
            'updated_date' => date('Y-m-d H:i:s'),
            ]);
            CtBillingSetting::ctbiillinglogs($input);
        return true;
    }
    
    public static function ctbiillinglogs($input = array()) {
        
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d H:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        //$ip = $_SERVER['REMOTE_ADDR'];
        //$data = \Location::get("175.100.138.136");
        
        CtBillingSettingsLog::create([
            'main_record_id' => $input['id'],
            'client_id' => $input['client_id'],
            'virtual_number' => $input['virtual_number'],
            'default_number' => $input['default_number'],
            'incoming_call_status' => $input['incoming_call_status'],            
            'incoming_pulse_duration' => $input['incoming_pulse_duration'],
            'incoming_pulse_rate' => $input['incoming_pulse_rate'],
            'outbound_call_status' => $input['outbound_call_status'],
            'outbound_pulse_duration' => $input['outbound_pulse_duration'],
            'outbound_pulse_rate' => $input['outbound_pulse_rate'],
            'rent_duration' => $input['rent_duration'],
            'rent_amount' => $input['rent_amount'],
            'activation_date' => date('Y-m-d', strtotime($input['activation_date'])),
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
