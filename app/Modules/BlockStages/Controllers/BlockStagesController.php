<?php namespace App\Modules\BlockStages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BlockStages\Models\BlockStages;


class BlockStagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            return view("BlockStages::index");
	}
        
        public function manageBlockStages() {
            $getBlockstage = BlockStages::all();
//echo "<pre>";print_r($getBlockstage);exit;
            if (!empty($getBlockstage)) {
                $result = ['success' => true, 'records' => $getBlockstage];
                return json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
                return json_encode($result);
            }
        }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
            $cnt = BlockStages::where(['block_stages' => $request['block_stages']])->get()->count();
            if ($cnt > 0) { 
                $result = ['success' => false, 'errormsg' => 'Block already exists'];
                return json_encode($result);
            } else {
                $getResult = BlockStages::create($request);
                $result = ['success' => true, 'result' => $getResult];
                return json_encode($result);
            }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
            $getCount = BlockStages::where(['block_stages' => $request['block_stages']])->get()->count();
            if ($getCount > 0) {
                $result = ['success' => false, 'errormsg' => 'Block already exists'];
                return json_encode($result);
            } else {
                $result = BlockStages::where('id', $request['id'])->update($request);
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
	public function destroy($id)
	{
		//
	}

}
