<?php

namespace App\Modules\ManageProfession\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProfession\Models\LstProfessions;
use DB;
use App\Classes\CommonFunctions;
class ManageProfessionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageProfession::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageProfession() {
        $getProfession = LstProfessions::all();

        if (!empty($getProfession)) {
            $result = ['success' => true, 'records' => $getProfession];
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
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstProfessions::where(['profession' => $request['profession']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Profession already exists'];
            return json_encode($result);
        } else {
            $create = CommonFunctions::insertMainTableRecords();
            $input['professionData'] = array_merge($request, $create);
            $result = LstProfessions::create($input['professionData']);
            $last3 = LstProfessions::latest('id')->first();
            $input['professionData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
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

        $getCount = LstProfessions::where(['profession' => $request['profession']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'profession already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['professionData'] = array_merge($request, $update);

            $create = CommonFunctions::insertMainTableRecords();
            $input['professioncreate'] = array_merge($request, $create);

            $originalValues = LstProfessions::where('id', $request['id'])->get();
            $result = LstProfessions::where('id', $request['id'])->update($input['professionData']);

            $last = DB::connection('masterdb')->table('lst_professions_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::connection('masterdb')->table('lst_professions_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];
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
