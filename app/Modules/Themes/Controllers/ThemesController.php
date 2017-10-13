<?php

namespace App\Modules\Themes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Themes\Models\WebThemes;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;
use Auth;
use DB;
use Excel;
use Validator;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;
use App\Http\Controllers\frontend\UserController;
use App\Modules\Testimonials\Models\WebTestimonials;
use App\Modules\WebPages\Models\WebPage;
use App\Modules\Projects\Models\Project;


class ThemesController extends UserController {

    public function index() {
        return view("Themes::index");
    }

    public function themePreview($id) {
        return view("Themes::themePreview")->with('id', $id);
    }
    
//     public function previewIndex($id) {
//    
//      $results = WebThemes::where('id', $id)->select(['id', 'theme_name'])->first();
////       print_r($result['theme_name']);exit;
////            Config::set('global.themeName', $result['theme_name']);
////            $this->themeName = Config::get('global.themeName');
//            $getWebsiteUrl = config('global.getWebsiteUrl');
//
//        $testimonials = WebTestimonials::where(['web_status' => '1', 'approve_status' => '1'])->get();
//        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
//                        ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
//                        ->select(["db2.first_name", "db2.personal_email1", "db2.last_name", "db2.id", "db1.designation"])
//                        ->orderByRaw("RAND()")->get();
//        $images = WebPage::where('page_name', 'index')->select('banner_images')->first();
//        $currentResult = [];
//        $current = Project::join('laravel_developement_master_edynamics.mlst_bmsb_project_status as mlst_bmsb_project_status', 'mlst_bmsb_project_status.id', '=', 'projects.project_status')
//                ->join('project_web_pages', 'project_web_pages.project_id', '=', 'projects.id')
//                ->select('mlst_bmsb_project_status.project_status as status', 'projects.id', 'projects.project_name', 'project_web_pages.project_logo', 'project_web_pages.project_amenities_list', 'project_web_pages.short_description')
//                ->where('mlst_bmsb_project_status.project_status', '=', 'Current')
//                ->get();
//        for ($i = 0; $i < count($current); $i++) {
//            $aminity = explode(',', $current[$i]['project_amenities_list']);
//            $aminities = DB::table('laravel_developement_master_edynamics.mlst_bmsb_amenities')->whereIn('id', $aminity)->select('name_of_amenity')->get();
//            $result = ['id' => $current[$i]['id'], 'project_name' => $current[$i]['project_name'], 'project_logo' => $current[$i]['project_logo'], 'amenities' => $aminities];
//            array_push($currentResult, $result);
//        }
//        return view('frontend.' . $results['theme_name'] . '.index')->with(["testimonials" => $testimonials, 'employee' => $employees, 'background' => $images, 'current' => $currentResult]);
//    }

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
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if (!empty($themePages)) {
            return json_encode(['records' => $themePages, 'exportData' => $export, 'delete' => $deleteBtn, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'No record', 'status' => false]);
        }
    }

    public function applyTheme() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $result = WebThemes::select('id')->where('status', '1')->first();
        $resultDetails = WebThemes::where('id', '=', $result['id'])->update(['status' => '0']);
        $apply = WebThemes::where('id', '=', $request['id'])->update(['status' => '1']);
        return json_encode(['records' => $apply, 'success' => true]);
    }

    public function deleteTheme() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['themeData'] = array_merge($request, $create);
        $themes = WebThemes::where('id', $request['id'])->update($input['themeData']);
        $result = ['success' => true, 'result' => $themes];
        return json_encode($result);
    }

    public function store() {
        $validationRules = WebThemes::validationRules();
        $validationMessages = WebThemes::validationMessages();

        $input = Input::all();

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['themeData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }

        $cnt = WebThemes::where(['theme_name' => $input['themeData']['theme_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Theme name already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['imageUrl'])) {
                $imageName = 'theme_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['imageUrl']->getClientOriginalExtension();

                $originalName = $input['imageUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {

                    $s3FolderName = "Themes";
                    $imageName = 'theme_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['imageUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['imageUrl']->getPathName(), $imageName, $s3FolderName);
                    $image_url = $imageName;

                    unset($input['imageUrl']);
                } else {
                    unset($input['imageUrl']);
                    $image_url = '';
                }
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $cre = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create['Themes'] = array_merge($input['themeData'], $cre);
            $create['Themes']['image_url'] = $image_url;
            $result = WebThemes::create($create['Themes']);
            $last3 = WebThemes::latest('id')->first();
            if (!empty($result)) {
                return json_encode(['records' => $result, 'lastinsertid' => $last3->id, 'image' => $image_url, 'success' => true]);
            } else {
                return json_encode(['errorMsg' => 'Failed to create', 'success' => false]);
            }
        }
    }

    public function update($id) {
        $validationRules = WebThemes::validationRules();
        $validationMessages = WebThemes::validationMessages();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['themeData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        $cnt = WebThemes::where(['theme_name' => $input['themeData']['theme_name']])->where('id', '!=', $id)->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Theme name already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['imageUrl'])) {
                $originalName = $input['imageUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {

                    $s3FolderName = "Themes";
                    $imageName = 'theme_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['imageUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['imageUrl']->getPathName(), $imageName, $s3FolderName);
                    $image_url = $imageName;
                    unset($input['imageUrl']);
                } else {
                    unset($input['imageUrl']);
                    $image_url = '';
                }
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $cre = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create['Themes'] = array_merge($input['themeData'], $cre);
            if (!empty($image_url)) {
                $create['Themes']['image_url'] = $image_url;
            } else {
                $create['Themes']['image_url'] = $input['image'];
            }
            unset($create['Themes']['image']);
            $result = WebThemes::where('id', '=', $id)->update($create['Themes']);

            return json_encode(['records' => $result, 'image' => $create['Themes']['image_url'], 'success' => true]);
        }
    }

    public function themeExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getCount = WebThemes::all()->count();
            $theme = WebThemes::all();
            $themePages = array();
            for ($i = 0; $i < count($theme); $i++) {
                $themeData['id'] = $theme[$i]['id'];
                $themeData['theme_name'] = $theme[$i]['theme_name'];
                $themePages[] = $themeData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Theme Data', function($excel) use($themePages) {
                    $excel->sheet('sheet1', function($sheet) use($themePages) {
                        $sheet->fromArray($themePages);
                    });
                })->download('csv');
            }
        }
    }

}
