<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use App\Models\ClientContactPerson;
use Illuminate\Support\Facades\DB;
use Reliese\Database\Eloquent\Model as Eloquent;
use App\Classes\CommonFunctions;
use App\Classes\S3;
use Auth;
/**
 * Class ClientInfo
 * 
 * @property int $id
 * @property string $client_id
 * @property bool $right_click
 * @property string $client_code
 * @property int $group_id
 * @property string $marketing_name
 * @property string $legal_name
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $office_addres
 * @property int $pin_code
 * @property string $company_logo
 * @property int $brand_id
 * @property string $website
 * @property int $website_with
 * @property \Carbon\Carbon $created_date
 * @property int $created_by
 * @property \Carbon\Carbon $updated_date
 * @property int $updated_by
 *
 * @package App\Models
 */
class ClientInfo extends Eloquent
{
	public $timestamps = false;
        
        protected $connection = 'masterdb';

	protected $casts = [
		'right_click' => 'bool',
		'group_id' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pin_code' => 'int',
		'brand_id' => 'int',
		'website_with' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
                'client_key',
                'group_id',
                'brand_id',
                'country_id',
		'state_id',
		'city_id',
		'right_click',
		'marketing_name',
		'legal_name',
		'type_of_company',
		'office_addres',
		'pin_code',
		'company_logo',
		'brand_id',
		'website',
		'website_with',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by'
	];
        
        public function getclientGroups()
        {
            return $this->belongsTo('App\Models\ClientGroup','group_id');
        }
        
        public function getlist($request)
        {
         
            if(!empty($request['id']) && $request['id'] !=0  )
            {
                $getClientLists = ClientInfo::where('id' ,  $request['id'])->first();
                $contactInfo    = ClientContactPerson::where('client_id',$request['id'])->get();
                
                if (!empty($getClientLists)) {
                    $count=count($getClientLists);
                    $result = ['success' => true, 'records' => $getClientLists,'count'=>$count,'contactflag'=>1,'contactinfo'=>$contactInfo];
                    return json_encode($result);
                } else {
                    $result = ['success' => false, 'message' => 'Something went wrong','contactflag'=>0,'count'=>$count];
                    return json_encode($result);
                }
            }
            else
            {    
                $getClientLists = ClientInfo::select('id','marketing_name','client_id','client_key','group_id','legal_name','website')
                                    ->with(['getclientGroups'=>function($query){
                                        $query->select('id','group_name');
                                    }])->get();
                if (!empty($getClientLists)) {
                    $count=count($getClientLists);
                    $result = ['success' => true, 'records' => $getClientLists,'count'=>$count];
                    return json_encode($result);
                } else {
                    $count=count($getClientLists);
                    $result = ['success' => false, 'message' => 'Something went wrong','count'=>$count];
                    return json_encode($result);
                }
            }
        } 
        
        
        public function createClientInfo($request)
        {
            $autoKey;
            $clientInfoCount = ClientInfo::count();
            if(empty($clientInfoCount))
                $autoKey=101;
            else
                $autoKey = 101 + $clientInfoCount;
            
            $create = CommonFunctions::insertMainTableRecords(Auth::guard('admin')->user()->id);
            $input['clientInfo'] = array_merge($request['data'],$create);
            $modelClientInfo = ClientInfo::create($input['clientInfo']);
            
            $clientId = $autoKey.'BMS'.@strtoupper(@substr($modelClientInfo->marketing_name,0,1).@substr($modelClientInfo->marketing_name,-1)).$modelClientInfo->id;
            
            $s3FolderName='client/'.$modelClientInfo->id."/";
            $marketingName = str_replace("'"," ",$modelClientInfo->marketing_name);
            $marketingName = str_replace('"'," ",$marketingName);
            $marketingName = str_replace(" ","_",$marketingName);
            
            $imageName = time()."_".@strtolower($marketingName).".".$request['data']['company_logo']->getClientOriginalExtension();
            
            $tempPath=$request['data']['company_logo']->getPathName();
            
            $name = S3::s3FileUpload($tempPath, $imageName, $s3FolderName);
            
            $modelClientInfo->client_id = $clientId;
            $modelClientInfo->client_key = \Hash::make($clientId);
            $modelClientInfo->company_logo= $name;
            $modelClientInfo->update();
            
            $clientContactList = $request['data']['contactInfo'];
            if(!empty($request['data']['contactInfo']))
            {    
                foreach($clientContactList as $clientcontact)
                {
                    $clientcontact['client_id'] = $modelClientInfo->id;
                    $clientcontact['group_id'] = $modelClientInfo->group_id;
                    $clientcontact['password'] = \Hash::make($clientcontact['password']);
                    unset($clientcontact['id']);                   
                    $createContact = CommonFunctions::insertMainTableRecords(Auth::guard('admin')->user()->id);
                    $input['clientContactInfo'] = array_merge($clientcontact,$createContact);
                    $modelClientContactInfo = ClientContactPerson::create($input['clientContactInfo']);


                }
            }
            $result = ['success' => true, 'result' => $modelClientInfo];
            return $result;
        } 
        
        
        public function updateClientInfo($request)
        {
            $company_Logo = $request['data']['company'];
            $company_Logo_flag=$request['data']['company_logo_flag'];
            
            unset($request['data']['company']);
            unset($request['data']['company_logo_flag']);
            
            $modelClientInfo = ClientInfo::where('id', $request['data']['id'])->first();
            
            if($company_Logo_flag == 1)
            { 
                $s3FolderName='client/'.$modelClientInfo->id."/";
                $marketingName = str_replace("'"," ",$modelClientInfo->marketing_name);
                $marketingName = str_replace('"'," ",$marketingName);
                $marketingName = str_replace(" ","_",$marketingName);
                $imageName = time()."_".@strtolower($marketingName).".".$request['data']['company_logo']->getClientOriginalExtension();
                $tempPath=$request['data']['company_logo']->getPathName();
                $name = S3::s3FileUpload($tempPath, $imageName, $s3FolderName);
                $request['data']['company_logo'] = $name;
            }
            else
            {
                $request['data']['company_logo']= $company_Logo;
            }    
            
            $update = CommonFunctions::updateMainTableRecords(Auth::guard('admin')->user()->id);
            $input['clientInfo'] = array_merge($request['data'],$update);
            $modelClientInfo->update($input['clientInfo']);
            
            if(!empty($request['data']['contactInfo']))
            {
                $clientContactList = $request['data']['contactInfo'];
                foreach($clientContactList as $clientcontact)
                {
                    $clientcontact['client_id'] = $modelClientInfo->id;
                    $clientcontact['group_id'] = $modelClientInfo->group_id;
                    if($clientcontact['id'] == 0)
                    {
                        unset($clientcontact['id']);                   
                        $clientcontact['password'] = \Hash::make($clientcontact['password']);
                        $createContact = CommonFunctions::insertMainTableRecords(Auth::guard('admin')->user()->id);
                        $input['clientContactInfo'] = array_merge($clientcontact,$createContact);
                        $modelClientContactInfo = ClientContactPerson::create($input['clientContactInfo']);
                    }    
                    else
                    {
                        if($clientcontact['high_security_password_type'] == 0)
                        {
                            $clientcontact['high_security_password'] = "0";
                        }
                        
                        $modelClientContactInfo = ClientContactPerson::where('id', $clientcontact['id'])->first(); 
                        $modelOldClientContactData = $modelClientContactInfo['attributes'];
                        $update = CommonFunctions::updateMainTableRecords(Auth::guard('admin')->user()->id);
                        $input['clientContactInfo'] = array_merge($clientcontact,$update);
                        $modelClientContactInfo->update($input['clientContactInfo']);
                        
                        
//                        $changeupdate_diff = array_diff_assoc($modelOldClientContactData,$clientcontact);
//                        $clientContactInfoArr = implode(",", array_keys($changeupdate_diff));
//                        $lastLogsInfo = DB::table('client_contact_persons_logs')->select('id')->orderBy('id', 'DESC')->first();
//                        $lastUpdateLog = DB::table('client_contact_persons_logs')->where('id', $lastLogsInfo->id)->update(['column_names' => $clientContactInfoArr]);

                    }    
                }
            }    
            
            
                        
            $result = ['success' => true];
            return $result;
        }        
}
