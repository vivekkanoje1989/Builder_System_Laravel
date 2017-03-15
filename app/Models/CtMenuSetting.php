<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Classes\CommonFunctions;

/**
 * Class CtMenuSetting
 * 
 * @property int $id
 * @property int $client_id
 * @property int $ct_settings_id
 * @property int $ext_number
 * @property string $ext_name
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
 * @property bool $ec_call_status
 * @property int $ec_welcome_tune_type_id
 * @property string $ec_welcome_tune
 * @property int $ec_hold_tune_type_id
 * @property string $ec_hold_tune
 * @property bool $msc_employee_type
 * @property int $msc_default_employee_id
 * @property bool $msc_facility_status
 * @property int $msc_welcome_tune_type_id
 * @property string $msc_welcome_tune
 * @property int $msc_call_insert_enquiry
 * @property bool $menu_status
 * @property \Carbon\Carbon $created_date
 * @property int $created_by
 * @property \Carbon\Carbon $updated_date
 * @property int $updated_by
 *
 * @package App\Models
 */
class CtMenuSetting extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'ct_settings_id' => 'int',
		'ext_number' => 'int',
		'ivr_type_id' => 'int',
		'welcome_tune_type_id' => 'int',
		'hold_tune_type_id' => 'int',
		'forwarding_type_id' => 'int',
		'forwarding_time' => 'int',
		'source_id' => 'int',
		'sub_source_id' => 'int',
		'model_project_id' => 'int',
		'insert_enquiry' => 'bool',
		'ec_call_status' => 'bool',
		'ec_welcome_tune_type_id' => 'int',
		'ec_hold_tune_type_id' => 'int',
		'msc_employee_type' => 'bool',
		'msc_default_employee_id' => 'int',
		'msc_facility_status' => 'bool',
		'msc_welcome_tune_type_id' => 'int',
		'msc_call_insert_enquiry' => 'int',
                'menu_status' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'ct_settings_id',
		'ext_number',
		'ext_name',
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
		'ec_call_status',
		'ec_welcome_tune_type_id',
		'ec_welcome_tune',
		'ec_hold_tune_type_id',
		'ec_hold_tune',
		'msc_employee_type',
		'msc_default_employee_id',
		'msc_facility_status',
		'msc_welcome_tune_type_id',
		'msc_welcome_tune',
		'msc_call_insert_enquiry',
                'menu_status',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by'
	];
        
        public static function validationMessages(){
        $messages = array(
            //'client_id.required' => 'Please select client',
            'ext_number' =>['required' => 'Please select extension number'],
            'ext_name.required' => 'Please enter extension number',
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
            'ext_number' => 'required|max:12',
            'ext_name' => 'required',
            'forwarding_type_id' => 'required',
            'source_id' => 'required|numeric',
            'model_project_id' => 'required',
        );
        return $rules;
    }
    
     public static function createMenuExtension($input = array()) {
         
        $employees='';
        $welcome_tune='';
        $hold_tune='';
        $msc_welcome_tune='';
        $empcount = count($input['employees1']);
        $j= $empcount - 1;
        if($empcount > 0){
            for($i=0;$i < $empcount;$i++){
                if($i<$j)
                    $employees .= $input['employees1'][$i]['id'].',';
                else
                    $employees .= $input['employees1'][$i]['id'];
            }
        }
        
        if($input['msc_facility_status'] == false || $input['msc_facility_status'] ==0){
                    $input['msc_facility_status'] = 0;
                }else{
                    $input['msc_facility_status'] = 1;
                }
                if($input['msc_facility_status'] == 0){
                    if($input['welcome_tune_type_id'] == 3){
                        if(!empty($input['welcome_tune_audio'])){
                        $wfileName = 'menu_welcome_tune'.date('Ymd').'.'.$input['welcome_tune_audio']->getClientOriginalExtension();
                        $input['welcome_tune_audio']->move(base_path()."/common/tunes/", $wfileName);
                        $welcome_tune = $wfileName;
                        }else{
                            $welcome_tune = $input['welcome_tune'];
                        }
                    }elseif($input['welcome_tune_type_id'] == 2){
                        $welcome_tune = $input['welcome_tune'];
                    }elseif($input['welcome_tune_type_id'] == 1){
                        $welcome_tune = '';
                    }
                    if($input['hold_tune_type_id'] == 3){
                        if(!empty($input['hold_tune_audio'])){
                        $hfileName = 'menu_hold_tune'.date('Ymd').'.'.$input['hold_tune_audio']->getClientOriginalExtension();
                        $input['hold_tune_audio']->move(base_path()."/common/tunes/", $hfileName);
                        $hold_tune = $hfileName;
                        }else{
                            $hold_tune = $input['hold_tune'];
                        }
                    }elseif($input['hold_tune_type_id'] == 2){
                        $hold_tune = $input['hold_tune'];
                    }elseif($input['hold_tune_type_id'] == 1){
                        $hold_tune = '';
                    }
                }else{
                    if($input['msc_welcome_tune_type_id'] == 3){
                        if(!empty($input['msc_welcome_tune_audio'])){
                        $nwhfileName = 'msc_tune'.date('Ymd').'.'.$input['msc_welcome_tune_audio']->getClientOriginalExtension();
                        $input['msc_welcome_tune_audio']->move(base_path()."/common/tunes/", $nwhfileName);
                        $msc_welcome_tune = $nwhfileName;
                        }else{
                            $msc_welcome_tune = $input['msc_welcome_tune'];
                        }
                    }elseif($input['msc_welcome_tune_type_id'] == 2){
                        $msc_welcome_tune = $input['msc_welcome_tune'];
                    }elseif($input['nwh_welcome_tune_type_id'] == 1){
                        $msc_welcome_tune = '';
                    }
                }
        if(empty($input['id'])){            
        $affectedRows = new CtMenuSetting();
        }else{
            $affectedRows = CtMenuSetting::where('id', '=', $input['id'])->get();
        }
        //print_r($affectedRows);exit;
        $affectedRows->client_id = 1;
        $affectedRows->ct_settings_id = $input['ct_settings_id'];
        $affectedRows->ext_number = $input['ext_number'];
        $affectedRows->ext_name = $input['ext_name'];            
        $affectedRows->ivr_type_id = 2;
        $affectedRows->welcome_tune_type_id = $input['welcome_tune_type_id'];
        $affectedRows->welcome_tune = $welcome_tune;
        $affectedRows->hold_tune_type_id = $input['hold_tune_type_id'];
        $affectedRows->hold_tune = $hold_tune;
        $affectedRows->forwarding_type_id = $input['forwarding_type_id'];
        if($input['forwarding_type_id'] > 1){
        $affectedRows->forwarding_time = $input['forwarding_time'];
        }else{
            $affectedRows->forwarding_time = 0;
        }
        $affectedRows->employees = $employees;
        $affectedRows->source_id = $input['source_id'];
        $affectedRows->source_disc = $input['source_disc'];
        $affectedRows->model_project_id = $input['model_project_id'];
        $affectedRows->insert_enquiry = $input['insert_enquiry'];
        if($input['msc_facility_status'] == 1){
        $affectedRows->msc_employee_type = $input['msc_employee_type'];
        $affectedRows->msc_default_employee_id = $input['msc_default_employee_id'];
        $affectedRows->msc_welcome_tune_type_id = $input['msc_welcome_tune_type_id'];
        $affectedRows->msc_welcome_tune =$msc_welcome_tune;
        $affectedRows->msc_call_insert_enquiry = $input['msc_call_insert_enquiry'];
        }
        $affectedRows->menu_status = $input['menu_status'];
        $affectedRows->created_by = Auth()->guard('admin')->user()->id;
        
        
        if($affectedRows->save()){
            return true;
        }else{
            return false;
        }
        //$this->ctbiillinglogs($input);
        
        
    }
    
    public static function updateMenuExtension($input = array()) {
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d H:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        
        $employees='';
        $welcome_tune='';
        $hold_tune='';
        $msc_welcome_tune='';
        $empcount = count($input['employees1']);
        $j= $empcount - 1;
        if($empcount > 0){
            for($i=0;$i < $empcount;$i++){
                if($i<$j)
                    $employees .= $input['employees1'][$i]['id'].',';
                else
                    $employees .= $input['employees1'][$i]['id'];
            }
        }
        
        if($input['msc_facility_status'] == false || $input['msc_facility_status'] ==0){
                    $input['msc_facility_status'] = 0;
                }else{
                    $input['msc_facility_status'] = 1;
                }
                if($input['msc_facility_status'] == 0){
                    if($input['welcome_tune_type_id'] == 3){
                        if(!empty($input['welcome_tune_audio'])){
                        $wfileName = 'menu_welcome_tune'.date('Ymd').'.'.$input['welcome_tune_audio']->getClientOriginalExtension();
                        $input['welcome_tune_audio']->move(base_path()."/common/tunes/", $wfileName);
                        $welcome_tune = $wfileName;
                        }else{
                            $welcome_tune = $input['welcome_tune'];
                        }
                    }elseif($input['welcome_tune_type_id'] == 2){
                        $welcome_tune = $input['welcome_tune'];
                    }elseif($input['welcome_tune_type_id'] == 1){
                        $welcome_tune = '';
                    }
                    if($input['hold_tune_type_id'] == 3){
                        if(!empty($input['hold_tune_audio'])){
                        $hfileName = 'menu_hold_tune'.date('Ymd').'.'.$input['hold_tune_audio']->getClientOriginalExtension();
                        $input['hold_tune_audio']->move(base_path()."/common/tunes/", $hfileName);
                        $hold_tune = $hfileName;
                        }else{
                            $hold_tune = $input['hold_tune'];
                        }
                    }elseif($input['hold_tune_type_id'] == 2){
                        $hold_tune = $input['hold_tune'];
                    }elseif($input['hold_tune_type_id'] == 1){
                        $hold_tune = '';
                    }
                }else{
                    if($input['msc_welcome_tune_type_id'] == 3){
                        if(!empty($input['msc_welcome_tune_audio'])){
                        $nwhfileName = 'msc_tune'.date('Ymd').'.'.$input['msc_welcome_tune_audio']->getClientOriginalExtension();
                        $input['msc_welcome_tune_audio']->move(base_path()."/common/tunes/", $nwhfileName);
                        $msc_welcome_tune = $nwhfileName;
                        }else{
                            $msc_welcome_tune = $input['msc_welcome_tune'];
                        }
                    }elseif($input['msc_welcome_tune_type_id'] == 2){
                        $msc_welcome_tune = $input['msc_welcome_tune'];
                    }elseif($input['nwh_welcome_tune_type_id'] == 1){
                        $msc_welcome_tune = '';
                    }
                }
                
                if($input['forwarding_type_id'] > 1){
                    $forwarding_time = $input['forwarding_time'];
                }else{
                    $forwarding_time = 0;
                }
        
        $affectedRows = CtMenuSetting::where('id', '=', $input['id'])->update([
        'ext_name' => $input['ext_name'],
        'welcome_tune_type_id' => $input['welcome_tune_type_id'],
        'welcome_tune' => $welcome_tune,
        'hold_tune_type_id' => $input['hold_tune_type_id'],
        'hold_tune' => $hold_tune,
        'forwarding_type_id' => $input['forwarding_type_id'],
        'forwarding_time' => $forwarding_time,
        'employees' => $employees,
        'source_id' => $input['source_id'],
        'source_disc' => $input['source_disc'],
        'model_project_id' => $input['model_project_id'],
        'insert_enquiry' => $input['insert_enquiry'],
        'msc_employee_type' => $input['msc_employee_type'],
        'msc_default_employee_id' => $input['msc_default_employee_id'],
        'msc_welcome_tune_type_id' => $input['msc_welcome_tune_type_id'],
        'msc_welcome_tune' =>$msc_welcome_tune,
        'msc_call_insert_enquiry' => $input['msc_call_insert_enquiry'],
        'menu_status' => $input['menu_status'],
        'updated_by' => Auth()->guard('admin')->user()->id,
        'updated_date' => date('Y-m-d H:i:s'),
        ]);
        return true;
        //$this->ctbiillinglogs($input);
        
        
    }
}
