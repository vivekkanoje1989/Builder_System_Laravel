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
 * @property int $virtual_display_number
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
 * @property int $project_id
 * @property int $block_id
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
class CtSetting extends Eloquent {

    public $timestamps = false;
    public $step = 1;
    protected $casts = [
        'ct_billing_settings_id' => 'int',
        'client_id' => 'int',
        'virtual_display_number' => 'int',
        'editing_status' => 'int',
        'default_number' => 'int',
        'menu_status' => 'int',
        'ivr_type_id' => 'int',
        'welcome_tune_type_id' => 'int',
        'hold_tune_type_id' => 'int',
        'forwarding_type_id' => 'int',
        'forwarding_time' => 'int',
        'source_id' => 'int',
        'sub_source_id' => 'int',
        'project_id' => 'int',
        'block_id' => 'int',
        'insert_enquiry' => 'int',
        'missed_call_insert_enquiry' => 'int',
        'ec_call_status' => 'int',
        'ec_welcome_tune_type_id' => 'int',
        'ec_hold_tune_type_id' => 'int',
        'alert_to_enq_owner' => 'int',
        'open_enquiry_owner_emp_action' => 'int',
        'open_enquiry_other_emp_action' => 'int',
        'lost_enquiry_owner_emp_action' => 'int',
        'lost_enquiry_other_emp_action' => 'int',
        'read_cust_name' => 'int',
        'read_emp_name' => 'int',
        'nwh_status' => 'int',
        'nwh_welcome_tune_type_id' => 'int',
        'nwh_call_insert_enquiry' => 'int',
        'msc_employee_type' => 'int',
        'msc_facility_status' => 'int',
        'msc_welcome_tune_type_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'inbound_call_status' => 'int',
        'outbound_call_status' => 'int'
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
        'virtual_display_number',
        'editing_status',
        'forwarding_number_knowlarity',
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
        'project_id',
        'block_id',
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

    public static function validationMessages() {
        $messages = array(
            'virtual_display_number' => ['required' => 'Please enter viwelcomertual number', 'numeric' => 'Please enter only digits', 'max' => 'Virtual number must be 12 digits only'],
            'welcome_tune_type_id.required' => 'Please select welcome tune type',
            'forwarding_type_id' => 'Please select forwarding type',
            'source_id' => 'Please select source',
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'virtual_display_number' => 'required|max:12',
            'welcome_tune_type_id' => 'required',
            'forwarding_type_id' => 'required',
            'source_id' => 'required|numeric',
        );
        return $rules;
    }

    public static function updateStep1($input = array()) {


        if (empty($input['set_to_all_welcome_tone'])) {
            $input['set_to_all_welcome_tone'] = false;
        }
        if (empty($input['set_to_all_hold_tone'])) {
            $input['set_to_all_hold_tone'] = false;
        }


        if (empty($input['default_number']))
            $input['default_number'] = 0;



        if ($input['menu_status'] == 0)
            $input['ivr_type_id'] = 1;
        else
            $input['ivr_type_id'] = 2;

        if ($input['forwarding_type_id'] == 1)
            $input['forwarding_time'] == 0;

        if (empty($input['project_id']))
            $input['project_id'] = 0;
        
        if (empty($input['block_id']))
            $input['block_id'] = 0;

        if (!empty($input['employees1'])) {
            $empcount = count($input['employees1']);
            $employees = '';
            $j = $empcount - 1;
            for ($i = 0; $i < $empcount; $i++) {
                if ($i < $j)
                    $employees .= $input['employees1'][$i]['id'] . ',';
                else
                    $employees .= $input['employees1'][$i]['id'];
            }
        }
        if (!empty($input['msc_default_employee_id'])) {
            $mscempcount = count($input['msc_default_employee_id']);
            $mscemployees = '';
            $j = $mscempcount - 1;
            for ($i = 0; $i < $mscempcount; $i++) {
                if ($i < $j)
                    $mscemployees .= $input['msc_default_employee_id'][$i]['id'] . ',';
                else
                    $mscemployees .= $input['msc_default_employee_id'][$i]['id'];
            }
        }
        if (empty($input['hold_tune_type_id'])) {
            $input['hold_tune_type_id'] = 0;
        }
        if ($input['menu_status'] == 1) {
            $employees = "";
        }
        if (empty($input['source_disc'])) {
            $input['source_disc'] = "";
        }
        if (empty($input['msc_default_employee_id'])) {
            $input['msc_default_employee_id'] = 0;
        }


        $affectedRows = CtSetting::where('id', '=', $input['id'])->update([
            'client_id' => $input['client_id'],
            'virtual_display_number' => $input['virtual_display_number'],
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
            'project_id' => $input['project_id'],
            'block_id' => $input['block_id'],
            'insert_enquiry' => $input['insert_enquiry'],
            'missed_call_insert_enquiry' => $input['missed_call_insert_enquiry'],
            'msc_default_employee_id' => !empty($mscemployees) ? $mscemployees : '',
            'employees' => $employees,
            'updated_by' => $input['loggedInUserId'],
            'updated_date' => date('Y-m-d H:i:s'),
        ]);


        if ($input['welcome_tune_type_id'] == 3 || $input['welcome_tune_type_id'] == 2) {
            if ($input['set_to_all_welcome_tone'] == true) {
                $whereData = array(array('id', '!=', $input['id']));
                $obj_other_numbers = CtSetting::where($whereData)->get();

                foreach ($obj_other_numbers as $obj_other_number_welcome) {
                    $obj_other_number_welcome->welcome_tune_type_id = $input['welcome_tune_type_id'];
                    $obj_other_number_welcome->welcome_tune = $input['welcome_tune'];
                    $obj_other_number_welcome->save();
                }
            }
        }

        if ($input['hold_tune_type_id'] == 3 || $input['hold_tune_type_id'] == 2) {
            if ($input['set_to_all_hold_tone'] == true) {
                $whereData = array(array('id', '!=', $input['id']));
                $obj_other_numbers = CtSetting::where($whereData)->get();

                foreach ($obj_other_numbers as $obj_other_number) {
                    $obj_other_number->hold_tune_type_id = $input['hold_tune_type_id'];
                    $obj_other_number->hold_tune = $input['hold_tune'];
                    $obj_other_number->save();
                }
            }
        }

        return true;
    }

    public static function updateStep2($input = array()) {

        if (empty($input['set_to_all_welcome_tone'])) {
            $input['set_to_all_welcome_tone'] = false;
        }
        if (empty($input['set_to_all_hold_tone'])) {
            $input['set_to_all_hold_tone'] = false;
        }


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
            'read_cust_name' => $input['read_cust_name'],
            'read_emp_name' => $input['read_emp_name'],
            'updated_by' => $input['loggedInUserId'],
            'updated_date' => date('Y-m-d H:i:s'),
        ]);

        if ($input['ec_welcome_tune_type_id'] == 3 || $input['ec_welcome_tune_type_id'] == 2) {
            if ($input['set_to_all_welcome_tone'] == true) {
                $whereData = array(array('id', '!=', $input['id']));
                $obj_other_numbers = CtSetting::where($whereData)->get();

                foreach ($obj_other_numbers as $obj_other_number_welcome) {
                    $obj_other_number_welcome->ec_welcome_tune_type_id = $input['ec_welcome_tune_type_id'];
                    $obj_other_number_welcome->ec_welcome_tune = $input['ec_welcome_tune'];
                    $obj_other_number_welcome->save();
                }
            }
        }

        if ($input['ec_hold_tune_type_id'] == 3 || $input['ec_hold_tune_type_id'] == 2) {
            if ($input['set_to_all_hold_tone'] == true) {
                $whereData = array(array('id', '!=', $input['id']));
                $obj_other_numbers = CtSetting::where($whereData)->get();

                foreach ($obj_other_numbers as $obj_other_number) {
                    $obj_other_number->ec_hold_tune_type_id = $input['ec_hold_tune_type_id'];
                    $obj_other_number->ec_hold_tune = $input['ec_hold_tune'];
                    $obj_other_number->save();
                }
            }
        }
        return true;
    }

    public static function updateStep4($input = array()) {

        if (empty($input['set_to_all_nwh_welcome_tone'])) {
            $input['set_to_all_nwh_welcome_tone'] = false;
        }

        $affectedRows = CtSetting::where('id', '=', $input['id'])->update([
            'nwh_status' => $input['nwh_status'],
            'nwh_start_time' => date('H:i:s', strtotime($input['nwh_start_time'])),
            'nwh_end_time' => date('H:i:s', strtotime($input['nwh_end_time'])),
            'nwh_welcome_tune_type_id' => $input['nwh_welcome_tune_type_id'],
            'nwh_welcome_tune' => $input['nwh_welcome_tune'],
            'nwh_call_insert_enquiry' => $input['nwh_call_insert_enquiry'],
            'updated_by' => $input['loggedInUserId'],
            'updated_date' => date('Y-m-d H:i:s'),
        ]);

        if ($input['nwh_welcome_tune_type_id'] == 3 || $input['nwh_welcome_tune_type_id'] == 2) {
            if ($input['set_to_all_nwh_welcome_tone'] == true) {
                $whereData = array(array('id', '!=', $input['id']));
                $obj_other_numbers = CtSetting::where($whereData)->get();

                foreach ($obj_other_numbers as $obj_other_number) {
                    $obj_other_number->nwh_welcome_tune_type_id = $input['nwh_welcome_tune_type_id'];
                    $obj_other_number->nwh_welcome_tune = $input['nwh_welcome_tune'];
                    $obj_other_number->save();
                }
            }
        }
        return true;
    }

    public function sourceName() {
        return $this->belongsTo('App\Models\MlstLmsaEnquirySalesSource', 'source_id'); //(customer model name, primary of customer model) 
    }

    public function subsourceName() {
        return $this->belongsTo('App\Models\EnquirySalesSubsource', 'sub_source_id'); //(customer model name, primary of customer model) 
    }
}
