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
use Auth;

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
        $webPages = array();
        for ($i = 0; $i < count($data); $i++) {
            $webData['id'] = $data[$i]['id'];
            $webData['page_name'] = $data[$i]['page_name'];
            $webData['page_title'] = $data[$i]['page_title'];
            $status = $data[$i]['status'];
            if ($status == 1) {
                $webData['status'] = 'active';
            } else {
                $webData['status'] = 'inactive';
            }

            $webPages[] = $webData;
        }
        if ($webPages) {
            $result = ['success' => true, 'records' => ["data" => $webPages, "total" => count($webPages), 'per_page' => count($webPages),
                    "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($webPages)]];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
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
        if (empty($alldata[0]['page_name']) || $alldata[0]['page_name'] == 'null') {
            $alldata[0]['page_name'] = '';
        }
        if (empty($alldata[0]['meta_description']) || $alldata[0]['meta_description'] == 'null') {
            $alldata[0]['meta_description'] = '';
        }
        if (empty($alldata[0]['meta_keywords']) || $alldata[0]['meta_keywords'] == 'null') {
            $alldata[0]['meta_keywords'] = '';
        }
        if (empty($alldata[0]['page_content']) || $alldata[0]['page_content'] == 'null') {
            $alldata[0]['page_content'] = '';
        }
        if (empty($alldata[0]['parent_page_position']) || $alldata[0]['parent_page_position'] == 'null') {
            $alldata[0]['parent_page_position'] = '';
        }
        if (empty($alldata[0]['seo_page_title']) || $alldata[0]['seo_page_title'] == 'null') {
            $alldata[0]['seo_page_title'] = '';
        }
        if (empty($alldata[0]['seo_url']) || $alldata[0]['seo_url'] == 'null') {
            $alldata[0]['seo_url'] = '';
        }
        if (empty($alldata[0]['canonical_tag']) || $alldata[0]['canonical_tag'] == 'null') {
            $alldata[0]['canonical_tag'] = '';
        }
        if ($alldata) {
            $result = ['success' => true, 'records' => $alldata];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPage() {

        $validationMessages = WebPage::validationMessages();
        $validationRules = WebPage::validationRules();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['contentData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['contentData']['loggedInUserId'])) {
            $loggedInUserId = $input['contentData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUpload($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

            $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['contentData']['banner_images'] = $name;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['contentData'] = array_merge($input['contentData'], $update);
        $updatedata = WebPage::where('id', $input['pageId'])->update($input['contentData']);
        echo json_encode(['success' => true, 'records' => $updatedata, 'message' => 'page updated successfully']);
    }

    public function storeSubWebPage() {
        $validationMessages = WebPage::validationMessages1();
        $validationRules = WebPage::validationRules1();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['subcontentPages'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUpload($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

            $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['subcontentPages']['banner_images'] = $name;
        $input['subcontentPages']['parent_id'] = $input['pageId'];
        $input['subcontentPages']['page_type'] = '1';
        $last = WebPage::where('page_type', '1')->orderBy('id', 'desc')->first();
        if (!empty($last->child_page_id)) {
            $input['subcontentPages']['child_page_id'] = $last->child_page_id + 1;
        } else {
            $input['subcontentPages']['child_page_id'] = '1';
        }
        $update = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['subcontentPages'] = array_merge($input['subcontentPages'], $update);

        $insertdata = WebPage::create($input['subcontentPages']);
        $latest = WebPage::latest('id')->first();
        return json_encode(['success' => true, 'records' => $input['subcontentPages'], 'id' => $latest->id, 'message' => 'page updated successfully']);
    }

    public function updateSubWebPage() {
        $validationMessages = WebPage::validationMessages1();
        $validationRules = WebPage::validationRules1();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['subcontentPage'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        if (!empty($input['userData']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUpload($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);

            $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $name = explode(',', $name);
        while (($i = array_search('fileNotSelected', $name)) !== false) {
            unset($name[$i]);
        }
        $name = implode(',', $name);
        $input['subcontentPage']['banner_images'] = $name;
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['parent_id'] = $input['pageId'];
        $input['subcontentPage']['page_type'] = '1';
        $last = WebPage::where('page_type', '1')->orderBy('id', 'desc')->first();
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['subcontentPage'] = array_merge($input['subcontentPage'], $update);
        unset($input['subcontentPage']['id']);

        $updatedata = WebPage::where('id', '=', $input['id'])->update($input['subcontentPage']);
        echo json_encode(['success' => true, 'records' => $input['subcontentPage'], 'message' => 'page updated successfully']);
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

    public function getSubImages() {
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

    public function getSubPages() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $getSubPages = [];
        $getSubPages = WebPage::where('parent_id', $obj['Data']['pageId'])->get();
        $getSubPages = json_decode(json_encode($getSubPages), true);
        if (!empty($getSubPages)) {
            for ($i = 0; $i < count($getSubPages); $i++) {
                if (empty($getSubPages[$i]['page_name']) || $getSubPages[$i]['page_name'] == 'null') {
                    $getSubPages[$i]['page_name'] = '';
                }
                if (empty($getSubPages[$i]['meta_description']) || $getSubPages[$i]['meta_description'] == 'null') {

                    $getSubPages[$i]['meta_description'] = '';
                }
                if (empty($getSubPages[$i]['meta_keywords']) || $getSubPages[$i]['meta_keywords'] == 'null') {
                    $getSubPages[$i]['meta_keywords'] = '';
                }
                if (empty($getSubPages[$i]['page_content']) || $getSubPages[$i]['page_content'] == 'null') {
                    $getSubPages[$i]['page_content'] = '';
                }
                if (empty($getSubPages[$i]['parent_page_position']) || $getSubPages[$i]['parent_page_position'] == 'null') {
                    $getSubPages[$i]['parent_page_position'] = '';
                }
                if (empty($getSubPages[$i]['seo_page_title']) || $getSubPages[$i]['seo_page_title'] == 'null') {
                    $getSubPages[$i]['seo_page_title'] = '';
                }
                if (empty($getSubPages[$i]['seo_url']) || $getSubPages[$i]['seo_url'] == 'null') {
                    $getSubPages[$i]['seo_url'] = '';
                }
                if (empty($getSubPages[$i]['canonical_tag']) || $getSubPages[$i]['canonical_tag'] == 'null') {
                    $getSubPages[$i]['canonical_tag'] = '';
                }
            }
        }

        if ($getSubPages != '') {
            $result = ['success' => true, 'records' => $getSubPages];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function updateWebPageImage() {
        $input = Input::all();

        if (array_key_exists('imageData', $input)) {
            $name = implode(",", $input['imageData']);
        } else {
            $name = '';
        }
        $s3FolderName = '/website/banner-images';
        for ($i = 0; $i < $input['totalImages']; $i++) {
            $imageName = 'website_' . $input['pageId'] . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['uploadImage'][$i]->getClientOriginalExtension();
            S3::s3FileUpload($input['uploadImage'][$i]->getPathName(), $imageName, $s3FolderName);
            $name .= ',' . $imageName;
        }
        $name = trim($name, ",");
        $updatedata = WebPage::where('id', $input['pageId'])->update(['banner_images' => $name]);
        $result = ['success' => true, 'message' => 'Image updated successfully'];
        echo json_encode($result);
    }

    public function removeWebPageImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['allimg']);
        $s3FolderName = '/website/banner-images/';
        $path = $s3FolderName . $obj['imageName'];
        $msg = S3::s3FileDelete($obj['imageName'], $s3FolderName);
        if ($msg) {
            $updatedata = WebPage::where('id', $obj['pageId'])->update(['banner_images' => $name]);
        } else {
            
        }
    }

    public function removeSubWebPageImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['subimgs']);
        $s3FolderName = '/website/banner-images/';
        $path = $s3FolderName . $obj['imageName'];
        $msg = S3::s3FileDelete($obj['imageName'], $s3FolderName);
        print_r($msg);
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
