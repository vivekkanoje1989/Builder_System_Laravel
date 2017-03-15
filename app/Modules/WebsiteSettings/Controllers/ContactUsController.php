<?php  namespace App\Modules\WebsiteSettings\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\Contactus;

class ContactusController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("WebsiteSettings::index");
	}

	public function manageContactUs()
	{
		$getContactus = Contactus::all();
            
        if(!empty($getContactus))
        {
            $result = ['success' => true, 'records' => $getContactus];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
	
    public function updateContactUs() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = Contactus::where(['address' => $request['address']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Address already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['countryData'] = array_merge($request,$update);
            
            $originalValues = Contactus::where('id', $request['id'])->get();
            $result = Contactus::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];
            
            $last = DB::table('contactus_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result =  DB::table('contactus_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
