<?php namespace App\Modules\ManageCountry\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\LstCountries;
use DB;
use App\Classes\CommonFunctions;

class ManageCountryController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("ManageCountry::index");
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
	 public function store() {
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
             $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        }
        
    }

    public function update($id) {
       $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = LstCountries::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
             
            $result = LstCountries::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
