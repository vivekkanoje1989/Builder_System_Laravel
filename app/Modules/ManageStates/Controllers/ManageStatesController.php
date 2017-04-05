<?php 

namespace App\Modules\ManageStates\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageStates\Models\MlstStates;
use App\Classes\CommonFunctions;
use App\Modules\ManageCountry\Models\MlstCountries;
use DB;
use Auth;
class ManageStatesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("ManageStates::index");
	}
       public function manageStates()
       {
         $getStates = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
          ->select('mlst_states.id', 'mlst_states.name','mlst_states.country_id', 'mlst_countries.name as country_name')
          ->get();
           if(!empty($getStates))
           {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
           }
           else
           {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
           }
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
        
        $cnt = MlstStates::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'State name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['stateData'] = array_merge($request,$create);
            $result = MlstStates::create($input['stateData']);
            $last3 = MlstStates::latest('id')->first();
            
            $getCountry = MlstCountries::where('id', '=',$request['country_id'])
               ->select('name')
               ->first(); 
            $input['stateData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id,'country_name'=>$getCountry->name];
           return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
      
        $getCount = MlstStates::where(['name' => $request['name'],'country_id' => $request['country_id']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
             
           
            $getCountry = MlstCountries::where('id', '=',$request['country_id'])
               ->select('name')
               ->first(); 
            
            $originalValues = LstStates::where('id', $request['id'])->get();
            $result = MlstStates::where('id', $request['id'])->update($request);
            
            $result = ['success' => true, 'result' => $result,'country_name'=>$getCountry->name];
          return json_encode($result);
        }
    }

}
