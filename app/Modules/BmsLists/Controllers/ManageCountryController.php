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
use App\Models\LstCountries;
use App\Models\LstCountriesLogs;


class ManageCountryController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("BmsLists::country");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function manageCountry()
	{
		$getCountry = LstCountries::all();
            
        if(!empty($getCountry))
        {
            $result = ['success' => true, 'records' => $getCountry];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
	 public function createCountry() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
     
        $cnt = LstCountries::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['countryData'] = array_merge($request,$create);
             $result = LstCountries::create($input['countryData']);
             $last3 = LstCountries::latest('id')->first();
            $input['countryData']['main_record_id'] = $last3->id;
             $input['countryData']['record_type'] = 1;
             $input['countryData']['record_restore_status'] = 1;
             $countryCreate =LstCountriesLogs::create($input['countryData']);
          
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        }
        
        
        
    }

    public function updateCountry() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = LstCountries::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['countryData'] = array_merge($request,$update);
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['countrycreate'] = array_merge($request,$create);
            
            $originalValues = LstCountries::where('id', $request['id'])->get();
            $result = LstCountries::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];
             
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
             
            $input['countrycreate']['record_type'] = 2;
            $input['countrycreate']['column_names'] = $implodeArr;
            $input['countrycreate']['record_restore_status'] = 1;
            $input['countrycreate']['id'] = '';
            $input['countrycreate']['main_record_id'] = $originalValues[0]['id'];
            $input['countrycreate']['record_type'] = 2;
            $input['countrycreate']['record_restore_status'] = 1;
            $input['countrycreate']['created_at'] = date("Y-m-d");
            $input['countrycreate']['created_by'] = Auth::guard('admin')->user()->id;
            $input['countrycreate']['updated_by'] = Auth::guard('admin')->user()->id;
            $countryUpdate = LstCountriesLogs::create($input['countrycreate']);   
            return json_encode($result);
        }
    }
	
}
