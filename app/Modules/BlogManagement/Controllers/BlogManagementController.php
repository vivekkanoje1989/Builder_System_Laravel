<?php

namespace App\Modules\BlogManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\BlogManagement\Models\Blogs;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Classes\CommonFunctions;

class BlogManagementController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("BlogManagement::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageBlogs() {
        $getBlogs = Blogs::all();
        if (!empty($getBlogs)) {
            $result = ['success' => true, 'records' => $getBlogs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function createBlogs() {
        return view("BlogManagement::create");
    }

    public function edit($id) {
        return view("BlogManagement::update")->with("blogId", $id);
    }

    public function getBlogsDetail() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getBlogs = Blogs::where('blog_id', $request['blog_id'])->first();
        if (!empty($getBlogs)) {
            $result = ['success' => true, 'records' => $getBlogs];
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
        $input = Input::all();
       
        $fileName = time() . '.' . $input['blogImages']['blog_banner_images']->getClientOriginalExtension();
        $input['blogImages']['blog_banner_images']->move(base_path() . "/common/blog_images/", $fileName);
        
        $cnt = Blogs::where(['blog_title' => $input['blog_title']])->get()->count();
        if ($cnt > 0) {  //exists blog_title
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['blogData'] = array_merge($input, $create);
            $input['blogData']['blog_code'] = date('Y').date('m').date('d').date('h').date('i').date('s').rand('1','10000'); 
            $blogData = Blogs::create($input['blogData']);
            $last3 = Blogs::latest('blog_id')->first();
            $result = ['success' => true, 'result' => $blogData, 'lastinsertid' => $last3->blog_id];
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

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        $input = Input::all();
      
        $fileName = time() . '.' . $input['blog_banner_images']->getClientOriginalExtension();
        $input['blog_banner_images']->move(base_path() . "/common/blog_images/", $fileName);

        $cnt = Blogs::where(['blog_title' => $input['blog_title']])->get()->count();
        if ($cnt > 0) {  //exists blog_title
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $originalValues = Blogs::where('blog_id', $blog_id)->get();
            $result = Blogs::where('blog_id', $blog_id)->update($input);

            $last = DB::table('blogs_logs')->latest('blog_id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $input);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('blogs_logs')->where('blog_id', $last->blog_id)->update(['column_names' => $implodeArr]);
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
