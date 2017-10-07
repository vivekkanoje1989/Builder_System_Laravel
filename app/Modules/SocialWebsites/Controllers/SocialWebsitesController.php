<?php

namespace App\Modules\SocialWebsites\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\SocialWebsites\Models\SocialWebsites;
use DB;
use App\Classes\CommonFunctions;

class SocialWebsitesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("SocialWebsites::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageSocialWebsite() {
        $getSocialWebsites = SocialWebsites::all();

        if (!empty($getSocialWebsites)) {
            $result = ['success' => true, 'records' => $getSocialWebsites];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = SocialWebsites::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Address already exists'];
            return json_encode($result);
        } else {
             $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::insertLogTableRecords($loggedInUserId);
            $input['socialData'] = array_merge($request, $update);

            $originalValues = SocialWebsites::where('id', $request['id'])->get();
            $result = SocialWebsites::where('id', $request['id'])->update($input['socialData']);
            $result = ['success' => true, 'result' => $result];

            $last = DB::table('social_websites_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('social_websites_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
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
