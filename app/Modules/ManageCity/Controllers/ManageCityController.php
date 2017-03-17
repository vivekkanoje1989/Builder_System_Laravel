<?php namespace App\Modules\ManageCity\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ManageCity\Models\LstCities;
use Illuminate\Http\Request;
use App\Modules\ManageCity\Models\LstCountries;
use App\Modules\ManageCity\Models\LstStates;
use DB;
use App\Classes\CommonFunctions;

class ManageCityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("ManageCity::index");
	}

	public function manageCity()
	{
		$getCities = LstCities::join('lst_states', 'lst_states.id', '=', 'lst_cities.id')
		                 ->join('lst_countries', 'lst_states.country_id', '=', 'lst_countries.id')
                          ->select('lst_cities.id', 'lst_cities.name', 'lst_states.name as state_name','lst_countries.name as country_name')
                          ->get();
        if(!empty($getCities))
        {
           $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
       public function  manageStates()
        {
            $postdata = file_get_contents('php://input');
           $request = json_decode($postdata, true);

            $getStates = LstStates::where('country_id',$request['country_name_id'])
		                 ->select('id', 'name')
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
	public function store()
	{
          $postdata = file_get_contents('php://input');
          $request = json_decode($postdata, true);
          $cnt = LstCities::where(['name' => $request['name']])->get()->count();
          if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
          } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['cityData'] = array_merge($request,$create);
             $result = LstCities::create($input['cityData']);
             $last3 = LstCities::latest('id')->first();
            $input['cityData']['main_record_id'] = $last3->id;
            
            $getCountry = LstCountries::where('id', '=',$request['country_id'])
               ->select('name')
               ->first(); 
            $getState= LstStates::where('id', '=',$request['state_id'])
               ->select('name')
               ->first(); 
            
             $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id,'country_name'=>$getCountry->name,'state_name'=>$getState->name];
              return json_encode($result);
            }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	
        

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
           $postdata = file_get_contents('php://input');
           $request = json_decode($postdata, true);
        
         $getCount = LstCities::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['cityData'] = array_merge($request,$update);
            $originalValues = LstCities::where('id', $request['id'])->get();
            $result = LstCities::where('id', $request['id'])->update($input['cityData']);
           $getState= LstStates::where('id', '=',$request['state_id'])
               ->select('name')
               ->first(); 
            $result = ['success' => true, 'result' => $result,'state_name'=>$getState->name];
             $last = DB::connection('masterdb')->table('lst_cities_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result1 =  DB::connection('masterdb')->table('lst_cities_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
           
            return json_encode($result);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
