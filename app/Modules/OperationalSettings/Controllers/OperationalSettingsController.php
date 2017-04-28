<?php

namespace App\Modules\OperationalSettings\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\OperationalSettings\Models\OperationalSettings;
use App\Modules\OperationalSettings\Models\lstEnquiryLocations;
use Auth;
use App\Classes\CommonFunctions;
class OperationalSettingsController extends Controller {

    public function index() {
        return view("OperationalSettings::index");
    }

    public function updatePreEnquiries() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['OperationalData'] = array_merge($request, $update);
        $operational = OperationalSettings::where('id', 1)->update($input['OperationalData']);
        if (!empty($operational)) {
            $result = ['success' => true, 'records' => $operational];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function budgetUpdate() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['OperationalData'] = array_merge($request, $update);
        $operational = OperationalSettings::where('id', 4)->update($input['OperationalData']);
        if (!empty($operational)) {
            $result = ['success' => true, 'records' => $operational];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageLocation() {

        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $locations = lstEnquiryLocations::where('city_id', $request['city_id'])->get();
        if (!empty($locations)) {
            $result = ['success' => true, 'records' => $locations];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function opeartionalArea() {

        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $locations = OperationalSettings::where('id', 3)->first();
        if ($locations['preferred_area'] == '') {
            $area_loc = $request['preferred_area'];
        } else {
            $preferred_area = $locations['preferred_area'] . "," . $request['preferred_area'];
            $locations = explode(',', $locations['preferred_area']);
            $area_location = array_unique($locations);
            $area_loc = implode(',', $area_location);
        }
        $post = ['preferred_area' => $area_loc];
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['OperationalData'] = array_merge($request, $post);
        $area = OperationalSettings::where('id', 3)->update($input['OperationalData']);
        if (!empty($area)) {
            $result = ['success' => true, 'records' => $area];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getOperationalSettings() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $area_loc = OperationalSettings::all();
        $locations = explode(',', $area_loc['2']['preferred_area']);
        $cart = array();
        for ($i = 0; $i < count($locations); $i++) {
            $area = lstEnquiryLocations::where('id', $locations[$i])->first();
            $location_name = array($locations[$i] => $area['location']);
            array_push($cart, $location_name);
        }
        if (!empty($area_loc)) {
            $result = ['success' => true, 'records' => $area_loc, 'areas' => $location_name, "allArea" => $cart];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function delArea() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $locations = OperationalSettings::where('id', 3)->first();
        $locations = explode(',', $locations['preferred_area']);
        $pos = array_search($request['area_id'], $locations);
        unset($locations[$pos]);
        $locations = implode(',', $locations);
        $post = ['preferred_area' => $locations];
        $area = OperationalSettings::where('id', 3)->update($post);
        if (!empty($area)) {
            $result = ['success' => true, 'records' => $area];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
