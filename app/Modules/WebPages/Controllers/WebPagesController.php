<?php
namespace App\Modules\WebPages\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\WebPages\Models\WebPage;
use Validator;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;

class WebPagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("WebPages::index");
    }

    public function getWebPages() {
        $data = WebPage::all();
        if ($data) {
            $result = ['success' => true, 'records' => ["data" => $data, "total" => count($data), 'per_page' => count($data),
                    "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($data)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function create() {
        //
    }
    
    public function store() {
        //
    }
    
    public function show($id) {
        //
    }
    
    public function edit($id) {
        return view("WebPages::updateWebPage")->with("pageId", $id);
    }

    public function getEditWebPage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $alldata = WebPage::where('id', $obj['Data']['pageId'])->get();
        if ($alldata) {
            $result = ['success' => true, 'records' => $alldata];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        //print_r($obj['contentData']);exit;
        $validationMessages = WebPage::validationMessages();
        $validationRules = WebPage::validationRules();
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
        $updatedata = WebPage::where('id', $obj['pageId'])->update($obj['contentData']);
        $result = ['success' => true, 'message' => 'page updated successfully'];
        echo json_encode($result);
    }

    public function getImages() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $getImages = WebPage::where('id', $obj['Data']['pageId'])->select('banner_images')->get();
        if ($getImages) {
            $result = ['success' => true, 'records' => $getImages];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPageImage() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $input = Input::all();
        $name = implode(",", $input['imageData']);
        $s3FolderName ='Banner-Images';  
        $name .= S3::s3FileUplod($input['uploadImage'], $s3FolderName,$input['totalImages']);
        
        /*  * *************** image upload  ****************** */
        /* $cnt = count($input['uploadImage']); 
         * for ($i = 0; $i < $cnt - 1; $i++) {
          $fileName = time() . $i . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
          $input['uploadImage'][$i]->move(base_path() . "/public/images/", $fileName);
          $name .= ',' . $fileName;
          } */
        $name = trim($name, ",");
        $updatedata = WebPage::where('id', $input['pageId'])->update(['banner_images' => $name]);
        $result = ['success' => true, 'message' => 'Image updated successfully'];
        echo json_encode($result);
    }

    public function removeWebPageImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['allimg']);
        $s3FolderName = 'Banner-Images';
        $msg = S3::s3FileDelete($obj['imageName'],$s3FolderName);

        /* if (file_exists(base_path() . '/public/images/' . $obj['imageName'])) {
          unlink(base_path() . "/public/images/" . $obj['imageName']);
          } else {

          }
         */
        if ($msg) {
            $updatedata = WebPage::where('id', $obj['pageId'])->update(['banner_images' => $name]);
        } else {
            
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
