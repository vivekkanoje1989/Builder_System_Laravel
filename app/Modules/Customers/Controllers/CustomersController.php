<?php namespace App\Modules\Customers\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Customers\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\S3;

class CustomersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
            return view("Customers::index");
	}

        public function manageCustomer() {
            $result = Customers::select('*')->with('getTitle','getProfession','getSource')->orderBy('id','ASC')->get();
            
            if (!empty($result)) {
                return json_encode(['result' => $result, 'status' => true]);
            } else {
                return json_encode(['mssg' => 'No records found', 'status' => false]);
            }
        }
        
        public function getcustomerData() {
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);            
            $result = Customers::where('id', $request['id'])->first();           
            if (!empty($result)) {
                return json_encode(['result' => $result, 'status' => true]);
            } else {
                return json_encode(['mssg' => 'No record found', 'status' => false]);
            }
        }
        
        /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
        public function update() {
            $input = Input::all();
            if (!empty($input['cust_image_file'])) {
                $originalName = $input['cust_image_file']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {
                    $s3FolderName = "Customer";
                    $imageName = 'customer_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['cust_image_file']->getClientOriginalExtension();
                    S3::s3FileUplod($input['cust_image_file']->getPathName(), $imageName, $s3FolderName);
                    $image_file = $imageName;
                    unset($input['cust_image_file']);
                } else {
                    unset($input['cust_image_file']);
                }
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['customerData'] = array_merge($input, $create);
            if(!empty($image_file))
            {
              $input['customerData']['image_file'] = $image_file;    
            }
            $input['customerData']['client_id'] = $loggedInUserId;
            $result = Customers::where('id', $input['id'])->update($input['customerData']);
            return json_encode(['result' => $result, 'status' => true]);
        }

        /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
        public function edit($id) {
            return view("Customers::edit")->with("custId", $id);
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
