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
use App\Models\LstState;


class ManageStatesController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("BmsLists::states");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function manageStates()
	{
            $getStates = LstState::
            join('lst_countries', 'lst_states.country_id', '=', 'lst_countries.id')
            ->select('lst_states.id', 'lst_states.name', 'lst_countries.name as country_name')
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
	 public function createStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstState::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $state = LstState::create($request);
            $result = ['success' => true, 'result' => $state];
            return json_encode($result);
        }
    }

    public function updateStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstState::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $result = LstState::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
