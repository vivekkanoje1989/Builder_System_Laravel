<?php

namespace App\Modules\ContactUs\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ContactUs\Models\WebContactus;
use Illuminate\Http\Request;
use DB;
use App\Modules\ManageCountry\Models\MlstCountries;
use App\Modules\ManageStates\Models\MlstStates;
use App\Modules\ManageCity\Models\MlstCities;
use App\Modules\EnquiryLocations\Models\lstEnquiryLocations;
use App\Classes\CommonFunctions;
use Auth;

class ContactUsController extends Controller {

    public function index() {
        return view("ContactUs::index");
    }

    public function manageContactUs() {
        $getContactus = WebContactus::all();
        $contactUs = array();
        for ($i = 0; $i < count($getContactus); $i++) {
            $contactData['id'] = $getContactus[$i]['id'];
            $contactData['address'] = $getContactus[$i]['address'];
            $contactData['pin_code'] = $getContactus[$i]['pin_code'];
            $contactData['email'] = $getContactus[$i]['email'];
            $contactData['contact_person_name'] = $getContactus[$i]['contact_person_name'];
            $contactUs[] = $contactData;
        }
        if (!empty($contactUs)) {
            $result = ['success' => true, 'records' => $contactUs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getStates = MlstStates::where('country_id', $request['country_name_id'])
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

    public function manageCity() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCities = MlstCities::where('state_id', $request['state_id'])
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
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getLocation = LstEnquiryLocations::where('city_id', $request['city_id'])->select('*')->get();
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
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['contactUsData'] = array_merge($request, $update);
        $result = WebContactus::where('id', $request['id'])->update($input['contactUsData']);
        $result = ['success' => true, 'result' => $result];
        return json_encode($result);
    }

}
