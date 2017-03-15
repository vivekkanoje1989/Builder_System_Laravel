<?php

namespace App\Modules\WebsiteSettings\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Classes\CommonFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class ContentPagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex() {
        return view("WebsiteSettings::index");
    }

    public function managePages() {
        $data = ContentPage::all();
        if ($data) {
            $result = ['success' => true, 'records' => ["data" => $data, "total" => count($data), 'per_page' => count($data),
                    "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($data)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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

    public function updateContentPage($pageId) {
        return view("WebsiteSettings::updateContentPage")->with("pageId", $pageId);
    }

    public function getContentPage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $alldata = ContentPage::where('page_id', $obj['Data']['pageId'])->get();
        if ($alldata) {
            $result = ['success' => true, 'records' => $alldata];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function saveContentPageSettings() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        //print_r($obj['contentData']);exit;
        $validationMessages = ContentPage::validationMessages();
        $validationRules = ContentPage::validationRules();
        if (!empty($obj['contentData'])) {
            $validator = Validator::make($obj['contentData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result, true);
                exit;
            }
        }
        $update = CommonFunctions::updateMainTableRecords();
        $obj['contentData'] = array_merge($obj['contentData'], $update);
        $updatedata = ContentPage::where('page_id', $obj['pageId'])->update($obj['contentData']);
        $result = ['success' => true, 'message' => 'page updated successfully'];
        echo json_encode($result);
    }

    public function getImages() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $getImages = ContentPage::where('page_id', $obj['Data']['pageId'])->select('banner_images')->get();
        if ($getImages) {
            $result = ['success' => true, 'records' => $getImages];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function saveImagePageSettings() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $input = Input::all();
        $name='';
       // print_r($input['pageId']);exit;
        $cnt = count($input['uploadImage']);
        /*         * *************** image upload  ****************** */
        for ($i = 0; $i < $cnt - 1; $i++) {
            $fileName = time().$i. '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            $input['uploadImage'][$i]->move(base_path() . "/public/images/", $fileName);
            $name.=$fileName.',';
        }
        
        $updatedata = ContentPage::where('page_id', $input['pageId'])->update(['banner_images' => $name]);
        $result = ['success' => true, 'message' => 'Image updated successfully'];
        echo json_encode($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
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
