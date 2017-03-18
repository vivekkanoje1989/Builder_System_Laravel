<?php

namespace App\Modules\ContactUs\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ContactUs\Models\Contactus;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;

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
        $getContactus = Contactus::all();

        if (!empty($getContactus)) {
            $result = ['success' => true, 'records' => $getContactus];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = Contactus::where(['address' => $request['address']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Address already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['countryData'] = array_merge($request, $update);

            $originalValues = Contactus::where('id', $request['id'])->get();
            $result = Contactus::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];

            $last = DB::table('contactus_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('contactus_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
