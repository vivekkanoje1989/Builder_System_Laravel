<?php

namespace App\Modules\ManageCity\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ManageCity\Models\MlstCities;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\MlstCountries;
use App\Modules\ManageStates\Models\MlstStates;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class ManageCityController extends Controller {

    public function index() {
        return view("ManageCity::index");
    }

    public function manageCity() {
        $getCities = MlstCities::join('mlst_states', 'mlst_states.id', '=', 'mlst_cities.id')
                ->join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
                ->select('mlst_cities.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
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

        $getStates = MlstStates::where('country_id', $request['country_id'])
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
        $getCountry = MlstCountries::all();

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
        $cnt = MlstCities::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $last3 = MlstCities::latest('id')->first();
            $input['cityData']['main_record_id'] = $last3->id;
            $getCountry = MlstCountries::where('id', '=', $request['country_id'])
                    ->select('name')
                    ->first();
            $getState = MlstStates::where('id', '=', $request['state_id'])
                    ->select('name')
                    ->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id, 'country_name' => $getCountry->name, 'state_name' => $getState->name];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstCities::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'City already exists'];
            return json_encode($result);
        } else {
            $result = MlstCities::where('id', $request['id'])->update($request);
            $getState = MlstStates::where('id', '=', $request['state_id'])
                    ->select('name')
                    ->first();
            $result = ['success' => true, 'result' => $result, 'state_name' => $getState->name];
            return json_encode($result);
        }
    }

}
