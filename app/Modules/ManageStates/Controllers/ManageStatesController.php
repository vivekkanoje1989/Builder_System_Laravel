<?php 

namespace App\Modules\ManageStates\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageStates\Models\LstStates;
use App\Classes\CommonFunctions;
use App\Modules\ManageCountry\Models\LstCountries;
use DB;

class ManageStatesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("ManageStates::states");
	}
       public function manageStates()
       {
         $getStates = LstStates::join('lst_countries', 'lst_states.country_id', '=', 'lst_countries.id')
          ->select('lst_states.id', 'lst_states.name','lst_states.country_id', 'lst_countries.name as country_name')
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
        
        $cnt = LstStates::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'State name already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['stateData'] = array_merge($request,$create);
            $result = LstStates::create($input['stateData']);
            $last3 = LstStates::latest('id')->first();
            
            $getCountry = LstCountries::where('id', '=',$request['country_id'])
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
      
        $getCount = LstStates::where(['name' => $request['name'],'country_id' => $request['country_id']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['statesData'] = array_merge($request,$update);
           
            $getCountry = LstCountries::where('id', '=',$request['country_id'])
               ->select('name')
               ->first(); 
            
            $originalValues = LstStates::where('id', $request['id'])->get();
            $result = LstStates::where('id', $request['id'])->update($input['statesData']);
            
            $last = DB::connection('masterdb')->table('lst_states_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result =  DB::connection('masterdb')->table('lst_states_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
            $result = ['success' => true, 'result' => $result,'country_name'=>$getCountry->name];
            
            return json_encode($result);
        }
    }

}
