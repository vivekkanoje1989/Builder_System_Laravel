<?php namespace App\Modules\WebsiteChangeModule\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Themes\Models\WebThemes;
use Illuminate\Http\Request;

class WebsiteChangeModuleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("WebsiteChangeModule::index");
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
        
         public function getThemes() {
        $theme = WebThemes::where('deleted_status', '!=', 1)->get();
        $themePages = array();
        for ($i = 0; $i < count($theme); $i++) {
           
            $themeData['id'] = $theme[$i]['id'];
            $themeData['theme_name'] = $theme[$i]['theme_name'];
            $themeData['image_url'] = $theme[$i]['image_url'];
            $themeData['status'] = $theme[$i]['status'];
            $themePages[] = $themeData;
        }
        
        if (!empty($themePages)) {
            return json_encode(['records' => $themePages, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'No record', 'status' => false]);
        }
    }

}
