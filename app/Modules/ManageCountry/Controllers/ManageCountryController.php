<?php namespace App\Modules\ManageCountry\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\MlstCountries;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class ManageCountryController extends Controller {
	public function index()
	{
		
		return view("ManageCountry::index");
	}
	public function manageCountry()
	{
		$getCountry = MlstCountries::all();
            
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
     
        $cnt = MlstCountries::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['countryData'] = array_merge($request,$create);
             $result = MlstCountries::create($input['countryData']);
             $last3 = MlstCountries::latest('id')->first();
            $input['countryData']['main_record_id'] = $last3->id;
             $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
              return json_encode($result);
        }
    }

    public function update($id) {
       $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = MlstCountries::where(['name' => $request['name']])
                                ->where('id','!=',$id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {
             
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['countryData'] = array_merge($request, $create);
            $result = MlstCountries::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
