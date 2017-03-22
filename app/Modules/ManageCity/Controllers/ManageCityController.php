<?php

namespace App\Modules\ManageCity\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ManageCity\Models\LstCities;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\LstCountries;
use App\Modules\ManageStates\Models\LstStates;
use DB;
use App\Classes\CommonFunctions;

class ManageCityController extends Controller {

    public function index() {
        return view("ManageCity::index");
    }

    public function manageCity() {
        $getCities = LstCities::join('lst_states', 'lst_states.id', '=', 'lst_cities.id')
                ->join('lst_countries', 'lst_states.country_id', '=', 'lst_countries.id')
                ->select('lst_cities.*', 'lst_states.country_id', 'lst_states.id as state_id', 'lst_cities.name', 'lst_states.name as state_name', 'lst_countries.name as country_name')
                ->get();
        if (!empty($getCities)) {
            $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getStates = LstStates::where('country_id', $request['country_id'])
                ->select('id', 'name')
                ->get();
        if (!empty($getStates)) {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageCountry() {
        $getCountry = LstCountries::all();

        if (!empty($getCountry)) {
            $result = ['success' => true, 'records' => $getCountry];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $cnt = LstCities::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $last3 = LstCities::latest('id')->first();
            $input['cityData']['main_record_id'] = $last3->id;

            $getCountry = LstCountries::where('id', '=', $request['country_id'])
                    ->select('name')
                    ->first();
            $getState = LstStates::where('id', '=', $request['state_id'])
                    ->select('name')
                    ->first();

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id, 'country_name' => $getCountry->name, 'state_name' => $getState->name];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = LstCities::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $result = LstCities::where('id', $request['id'])->update($request);
            $getState = LstStates::where('id', '=', $request['state_id'])
                    ->select('name')
                    ->first();
           
            $result = ['success' => true, 'result' => $result, 'state_name' => $getState->name];
            return json_encode($result);
        }
    }

}
