<?php

namespace App\Modules\ContactUs\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ContactUs\Models\WebContactus;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;
use App\Modules\ManageCountry\Models\LstCountries;
use App\Modules\ManageStates\Models\LstStates;
use App\Modules\ManageCity\Models\LstCities;
use App\Modules\ManageLocation\Models\LstLocationTypes;

class ContactUsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ContactUs::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageContactUs() {
        $getContactus = WebContactus::all();

        if (!empty($getContactus)) {
            $result = ['success' => true, 'records' => $getContactus];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getStates = LstStates::where('country_id', $request['country_name_id'])
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

    public function manageCity() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCities = LstCities::where('state_id', $request['state_id'])
                ->select('id', 'name')
                ->get();
        if (!empty($getCities)) {
            $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getContactUsRow() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getContactus = WebContactus::where('id', $request['id'])->select('*')->first();
        if (!empty($getContactus)) {
            $result = ['success' => true, 'records' => $getContactus];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageLocation() {
        $getLocation = LstLocationTypes::all();
        if (!empty($getLocation)) {
            $result = ['success' => true, 'records' => $getLocation];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::insertLogTableRecords($loggedInUserId);
        $input['countryData'] = array_merge($request, $update);

        $originalValues = WebContactus::where('id', $request['id'])->get();
        $result = WebContactus::where('id', $request['id'])->update($input['countryData']);
        $result = ['success' => true, 'result' => $result];

        $last = DB::table('web_contactus_logs')->latest('id')->first();
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
        $implodeArr = implode(",", array_keys($getResult));
        $result = DB::table('web_contactus_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
        $result = ['success' => true, 'result' => $result];
        return json_encode($result);
    }

}
