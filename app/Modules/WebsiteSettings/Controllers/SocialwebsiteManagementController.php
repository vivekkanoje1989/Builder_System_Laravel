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
use App\Models\SocialWebsites;

class SocialwebsiteManagementController extends Controller {
 
	
	public function index()
	{
		
		return view("WebsiteSettings::socialwebsite");
	}

	public function manageSocialWebsite()
	{
	   $getSocialWebsites = SocialWebsites::all();
            
        if(!empty($getSocialWebsites))
        {
            $result = ['success' => true, 'records' => $getSocialWebsites];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
	
    public function updateSocialWebsite() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = SocialWebsites::where(['name' => $request['name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Address already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['socialData'] = array_merge($request,$update);
            
            $originalValues = SocialWebsites::where('id', $request['id'])->get();
            $result = SocialWebsites::where('id', $request['id'])->update($input['socialData']);
            $result = ['success' => true, 'result' => $result];
            
            $last = DB::table('social_websites_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result =  DB::table('social_websites_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
