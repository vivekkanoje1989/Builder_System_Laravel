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
use App\Models\LstCity;


class ManageCitiesController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("BmsLists::cities");
	}
	public function manageCities()
	{
		$getCities = LstCity::join('lst_states', 'lst_states.id', '=', 'lst_cities.id')
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
	public function createCities() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstCity::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $state = LstCity::create($request);
            $result = ['success' => true, 'result' => $state];
            return json_encode($result);
        }
    }

    public function updateCities() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        
        $getCount = LstCity::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $result = LstCity::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
