<?php

namespace App\Modules\BlogManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\BlogManagement\Models\WebBlogs;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Classes\CommonFunctions;
use Auth;
use Validator;
use App\Classes\S3;

class BlogManagementController extends Controller {

    public function index() {
        return view("BlogManagement::index");
    }

    public function manageBlogs() {
        $getBlogs = WebBlogs::all();
        $blogDetails = array();
         for($i=0;$i<count($getBlogs);$i++){
             $blogData['id'] = $getBlogs[$i]['id'];
             $blogData['blog_title'] = $getBlogs[$i]['blog_title'];
             $blogData['blog_seo_url'] = $getBlogs[$i]['blog_seo_url'];
             $blogData['meta_description'] = $getBlogs[$i]['meta_description'];
             $blogData['meta_keywords'] = $getBlogs[$i]['meta_keywords'];
             $status = $getBlogs[$i]['blog_status'];
             if($status == 1){
                 $blogData['blog_status'] = 'Yes';
             }else{
                 $blogData['blog_status'] = 'No';
             }
             
             $blogDetails[] = $blogData;
        }
        if (!empty($blogDetails)) {
            $result = ['success' => true, 'records' => $blogDetails];
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
        return view("BlogManagement::update")->with("id", $id);
    }

    public function getBlogsDetail() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getBlogs = WebBlogs::where('id', $request['blog_id'])->first();
        if (!empty($getBlogs)) {
            $result = ['success' => true, 'records' => $getBlogs];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $validationRules = WebBlogs::validationRules();
        $validationMessages = WebBlogs::validationMessages();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['blogData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (!empty($input['blogImages']['blog_banner_images'])) {
            $originalName = $input['blogImages']['blog_banner_images']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {

                $s3FolderName = "Blog/blog_banner_images";
                $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['blogImages']['blog_banner_images']->getClientOriginalExtension();
                S3::s3FileUpload($input['blogImages']['blog_banner_images']->getPathName(), $imageName, $s3FolderName);
                $banner_images = $imageName;
            } else {
                unset($input['blog_banner_images']);
                $banner_images = '';
            }
        }
        if (!empty($input['galleryImage']['galleryImage'])) {
            $imgCount = count($input['galleryImage']['galleryImage']);
            if ($imgCount > 0) {
                $name = '';
                $s3FolderName = "Blog/gallery_image";
                for ($i = 0; $i < $imgCount; $i++) {
                    $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['galleryImage']['galleryImage'][$i]->getClientOriginalExtension();
                    S3::s3FileUpload($input['galleryImage']['galleryImage'][$i]->getPathName(), $imageName, $s3FolderName);
                    $name .= ',' . $imageName;
                }
                $allfile = trim($name, ",");
            }
        } else {
            $allfile = '';
            unset($input['blog_images']);
        }
        $cnt = WebBlogs::where(['blog_title' => $input['blogData']['blog_title']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['blogData'] = array_merge($input['blogData'], $create);

            $input['blogData']['blog_code'] = date('Y') . date('m') . date('d') . date('h') . date('i') . date('s') . rand('1', '10000');
            $input['blogData']['blog_banner_images'] = $banner_images;
            $input['blogData']['blog_images'] = $allfile;
            $blogData = WebBlogs::create($input['blogData']);
            $result = ['success' => true, 'result' => $blogData];
            return json_encode($result);
        }
    }

    public function update($id) {
        $validationRules = WebBlogs::validationRules();
        $validationMessages = WebBlogs::validationMessages();

        $input = Input::all();
        if (array_key_exists('blogimgs', $input)) {
            $name = implode(",", $input['blogimgs']);
        } else {
            $name = '';
        }
        $blog = $input['blogData']['blog_title'];
        $isBlogExist = WebBlogs::where('blog_title', '=', $blog)->first();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['blogData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }

        if (!empty($input['blogImages']['blog_banner_images'])) {
            $originalName = $input['blogImages']['blog_banner_images']->getClientOriginalName();

            if ($originalName !== 'fileNotSelected') {
                $s3FolderName = "Blog/blog_banner_images";
                $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['blogImages']['blog_banner_images']->getClientOriginalExtension();
                S3::s3FileUpload($input['blogImages']['blog_banner_images']->getPathName(), $imageName, $s3FolderName);
                $banner_images = $imageName;
                $input['blogData']['blog_banner_images'] = $banner_images;
            } else {
                unset($input['blogImages']['blog_banner_images']);
            }
        }


        foreach ($input['galleryImage'] as $key => $value) {
            $isMultipleArr = is_array($input['galleryImage'][$key]);
            if ($isMultipleArr) {
                $originalName = $input['galleryImage'][$key][0]->getClientOriginalName();
            } else {
                $originalName = $input['galleryImage'][$key]->getClientOriginalName();
            }

            if ($originalName != 'fileNotSelected') {
                $imgCount = count($input['galleryImage']['galleryImage']);
                if ($imgCount > 0) {
                    $s3FolderName = "Blog/gallery_image";
                    for ($i = 0; $i < $imgCount; $i++) {
                        $imageName = 'blog_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['galleryImage']['galleryImage'][$i]->getClientOriginalExtension();
                        S3::s3FileUpload($input['galleryImage']['galleryImage'][$i]->getPathName(), $imageName, $s3FolderName);
                        $name .= ',' . $imageName;
                    }
                    $allfile = trim($name, ",");
                    $name = trim($name, ",");
                    $name = explode(',', $name);
                    while (($i = array_search('fileNotSelected', $name)) !== false) {
                        unset($name[$i]);
                    }
                    $name = implode(',', $name);
                    
                    $input['blogData']['blog_images'] = $name;
                }
            } else {
                $input['blogData']['blog_images'] = $input['blogData']['blog_images'];
            }
        }

        $cnt = WebBlogs::where(['blog_title' => $input['blogData']['blog_title']])->where('id', '!=', $id)->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Blog title already exists'];
            return json_encode($result, true);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['blogData'] = array_merge($input['blogData'], $create);
            
            unset($input['blogData']['blogImages']);
//            unset($input['blogData']['galleryImage']);
            unset($input['blogData']['allgallery']);
            unset($input['blogData']['allbanner']);
            $blogData = WebBlogs::where('id', '=', $id)->update($input['blogData']);
            $result = ['success' => true, 'result' => $blogData];
        }
        return json_encode($result);
    }

    
     public function removeImage() {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata, true);
        $name = implode(',', $obj['galleryImage_preview']);
        $s3FolderName = 'Blog/gallery_image';
        $obj['imageName'] . "     " . $s3FolderName;
        $msg = S3::s3FileDelete($obj['imageName'], $s3FolderName);
        $updatedata = WebBlogs::where('id', $obj['pageId'])->update(['blog_images' => $name]);
    }
    

}
