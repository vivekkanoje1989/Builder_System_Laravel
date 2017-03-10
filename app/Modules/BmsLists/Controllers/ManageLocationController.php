<?php namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\LstLocationTypes;
use App\Models\LstLocationTypesLogs;


class ManageLocationController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("BmsLists::location");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function manageLocation()
	{
		//$getStates = LstState::all();

		$getLocation = LstLocationTypes::all();
            
        if(!empty($getLocation))
        {
            $result = ['success' => true, 'records' => $getLocation];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
	 public function createLocation() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        
         $cnt = LstLocationTypes::where(['location_type' => $request['location_type']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['locationData'] = array_merge($request,$create);
             $result = LstLocationTypes::create($input['locationData']);
             $last3 = LstLocationTypes::latest('id')->first();
            $input['locationData']['main_record_id'] = $last3->id;
             $input['locationData']['record_type'] = 1;
             $input['locationData']['record_restore_status'] = 1;
             $countryCreate =LstLocationTypesLogs::create($input['locationData']);
          
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        }
        
        
    }

    public function updateLocation() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = LstLocationTypes::where(['location_type' => $request['location_type']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Location already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['locationData'] = array_merge($request,$update);
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['locationcreate'] = array_merge($request,$create);
            
            $originalValues = LstLocationTypes::where('id', $request['id'])->get();
            $result = LstLocationTypes::where('id', $request['id'])->update($input['locationData']);
            $result = ['success' => true, 'result' => $result];
             
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
             
            $input['locationcreate']['record_type'] = 2;
            $input['locationcreate']['column_names'] = $implodeArr;
            $input['locationcreate']['record_restore_status'] = 1;
            $input['locationcreate']['id'] = '';
            $input['locationcreate']['main_record_id'] = $originalValues[0]['id'];
            $input['locationcreate']['record_type'] = 2;
            $input['locationcreate']['record_restore_status'] = 1;
            $input['locationcreate']['created_at'] = date("Y-m-d");
            $input['locationcreate']['created_by'] = Auth::guard('admin')->user()->id;
            $input['locationcreate']['updated_by'] = Auth::guard('admin')->user()->id;
            $locationUpdate = LstLocationTypesLogs::create($input['locationcreate']);   
            return json_encode($result);
        }
        
        
    }
	
}
