<?php namespace App\Modules\BlogManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\BlogManagement\Models\Blogs;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;

class BlogManagementController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("BlogManagement::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
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
            return view("BlogManagement::create");
        }

         public function edit($id) {
            return view("BlogManagement::update")->with("blogId", $id);
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
	

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
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
