<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Apr 2017 13:30:55 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FirmPartner
 * 
 * @property int $id
 * @property string $marketing_name
 * @property string $punch_line
 * @property string $sms_alias
 * @property string $receipt_alias
 * @property string $legal_name
 * @property string $firm_logo
 * @property string $letter_head
 * @property string $stamp
 * @property string $firm_url
 * @property string $footer_info
 * @property string $pan_num
 * @property string $service_tax_num
 * @property string $vat_num
 * @property string $main_office_addr
 * @property string $owner_name
 * @property string $owner_mobile1
 * @property string $owner_mobile2
 * @property string $owner_email
 * @property \Carbon\Carbon $owner_birth_date
 * @property string $second_owner_name
 * @property string $second_owner_mobile1
 * @property string $second_owner_mobile2
 * @property string $second_owner_email
 * @property \Carbon\Carbon $second_owner_birth_date
 * @property string $third_owner_name
 * @property string $third_owner_mobile1
 * @property string $third_owner_mobile2
 * @property string $third_owner_email
 * @property \Carbon\Carbon $third_owner_birth_date
 * @property string $bank_account
 * @property string $other
 * @property string $other1
 * @property string $estimate_logo
 * @property string $company_add_proof
 * @property string $company_registered_doc
 * @property string $pan_scan
 * @property string $use_for_cloud_bill_address
 * @property string $domain_name
 *
 * @package App\Models
 */
class FirmPartner extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'owner_birth_date',
		'second_owner_birth_date',
		'third_owner_birth_date'
	];

	protected $fillable = [
		'marketing_name',
		'punch_line',
		'sms_alias',
		'receipt_alias',
		'legal_name',
		'firm_logo',
		'letter_head',
		'stamp',
		'firm_url',
		'footer_info',
		'pan_num',
		'service_tax_num',
		'vat_num',
		'main_office_addr',
		'owner_name',
		'owner_mobile1',
		'owner_mobile2',
		'owner_email',
		'owner_birth_date',
		'second_owner_name',
		'second_owner_mobile1',
		'second_owner_mobile2',
		'second_owner_email',
		'second_owner_birth_date',
		'third_owner_name',
		'third_owner_mobile1',
		'third_owner_mobile2',
		'third_owner_email',
		'third_owner_birth_date',
		'bank_account',
		'other',
		'other1',
		'estimate_logo',
		'company_add_proof',
		'company_registered_doc',
		'pan_scan',
		'use_for_cloud_bill_address',
		'domain_name'
	];
}
