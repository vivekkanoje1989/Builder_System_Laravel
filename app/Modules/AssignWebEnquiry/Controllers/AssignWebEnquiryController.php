<?php namespace App\Modules\AssignWebEnquiry\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;

use App\Modules\AssignWebEnquiry\Models\AssignWebEnquiries;

class AssignWebEnquiryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("AssignWebEnquiry::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function manageAutoEnquiries()
	{
		 $rows = DB::table('employees')->select('first_name','last_name','id')->get();
         
           if (!empty($rows)) {
                $result = ['success' => true, 'records' =>  $rows];
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
	public function store()
	{
		//
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
       
         $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::insertLogTableRecords($loggedInUserId);
            $input['AutoEnquiriesData'] = array_merge($request,$update);
            
            $originalValues = AssignWebEnquiries::first();
            $result = AssignWebEnquiries::where('id', 1)->update($input['AutoEnquiriesData']);
            $result = ['success' => true, 'result' => $result];
            
            $last = DB::table('assign_web_enquiries_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result =  DB::table('assign_web_enquiries_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
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
