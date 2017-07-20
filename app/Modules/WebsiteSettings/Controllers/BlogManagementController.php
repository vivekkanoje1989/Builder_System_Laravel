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
use App\Models\Blogs;

class BlogManagementController extends Controller {
 
	public function index()
	{
		
		return view("WebsiteSettings::blogs");
	}
        public function blogCreate()
	{
		
		return view("WebsiteSettings::blogcreate");
	}
	public function manageBlogs()
	{
	   $getBlogs = Blogs::all();
            if(!empty($getBlogs))
           {
                $result = ['success' => true, 'records' => $getBlogs];
               return json_encode($result);
           }
           else
           {
               $result = ['success' => false,'message' => 'Something went wrong'];
               return json_encode($result);
           }
	}
        public function createBlogs()
        {
            $input = Input::all(); 
//            $postdata = file_get_contents('php://input');
//           $request = json_decode($postdata, true);
        print_r($input['blogImages']['blog_banner_images']);
        exit();
        
           $cnt = Blogs::where(['blog_title' => $input['blog_title']])->get()->count();
           if ($cnt > 0) {  //exists blog_title
               $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
               return json_encode($result);
              } else {
            
               $create = CommonFunctions::insertMainTableRecords();
               $input['blogData'] = array_merge( $input,$create);
               $blogData = Blogs::create($input['blogData']);
               $last3 = Blogs::latest('blog_id')->first();
               $result = ['success' => true, 'result' => $blogData,'lastinsertid'=>$last3->blog_id];
            return json_encode($result);
        }
        }
        
        public function edit($id) {
            return view("WebsiteSettings::blogupdate")->with("blogId", $id);
        }
        public function getBlogsDetail()
        {
            $postdata = file_get_contents('php://input');
            $request = json_decode($postdata, true);
           
            $getBlogs = Blogs::where('blog_id',$request['blog_id'])->first();
            if(!empty($getBlogs))
           {
                $result = ['success' => true, 'records' => $getBlogs];
               return json_encode($result);
           }
           else
           {
               $result = ['success' => false,'message' => 'Something went wrong'];
               return json_encode($result);
           }
        }
	
       public function updateBlogs() {
          $postdata = file_get_contents('php://input');
           $request = json_decode($postdata, true);
          
           $cnt = Blogs::where(['blog_title' => $request['blog_title']])->get()->count();
           if ($cnt > 0) {  //exists blog_title
               $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
               return json_encode($result);
              } else {
            
               $update = CommonFunctions::insertLogTableRecords();
            $input['blogData'] = array_merge($request,$update);
            $originalValues = Blogs::where('blog_id', $request['blog_id'])->get();
            $result = Blogs::where('blog_id', $request['blog_id'])->update($input['blogData']);
            
           // $last = DB::table('blogs_logs')->latest('blog_id')->first();
            //$getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            //$implodeArr =  implode(",",array_keys($getResult));
            //$result =  DB::table('blogs_logs')->where('blog_id',$last->blog_id)->update(['column_names'=>$implodeArr]);
            $result = ['success' => true, 'result' => $result];
          return json_encode($result);
        }
    }
    
     
    
	
}
