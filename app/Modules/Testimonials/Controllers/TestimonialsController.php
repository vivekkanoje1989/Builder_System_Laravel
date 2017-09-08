<?php

namespace App\Modules\Testimonials\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Modules\Testimonials\Models\WebTestimonials;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;
use Auth;
use Excel;
use Validator;

class TestimonialsController extends Controller {

    public function index() {
        return view("Testimonials::index");
    }

    public function show() {
        return view("Testimonials::manage");
    }

    public function create() {
        return view("Testimonials::create");
    }

    public function editApproved($id) {
        return view("Testimonials::editApprovedList")->with("testimonialId", $id);
    }

    public function getDisapproveList() {

        $getApprovedTestimonials = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')->where('approve_status', '0')->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials, 'exportData' => $export];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function manageTestimonialDisapproveExportToExcel() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getApprovedTestimonials = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')
                    ->where('approve_status', '0')
                    ->get();

            $getCount = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')
                    ->where('approve_status', '0')
                    ->get()
                    ->count();
            $getApprovedTestimonials = json_decode(json_encode($getApprovedTestimonials), true);
            $testimonialData = array();
            $j = 1;
            for ($i = 0; $i < count($getApprovedTestimonials); $i++) {

                $testimonial['Sr No.'] = $j++;
                $testimonial['Customer Name'] = $getApprovedTestimonials[$i]['customer_name'];
                $testimonial['Mobile Number'] = $getApprovedTestimonials[$i]['mobile_number'];
                $testimonial['Company Name'] = $getApprovedTestimonials[$i]['company_name'];
                if ($getApprovedTestimonials[$i]['approve_status'] == '1') {
                    $testimonial['Status'] = 'Approved';
                } else {
                    $testimonial['Status'] = 'Not Approve';
                }
                $testimonialData[] = $testimonial;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Testimonial Details', function($excel) use($testimonialData) {
                    $excel->sheet('sheet1', function($sheet) use($testimonialData) {
                        $sheet->fromArray($testimonialData);
                    });
                })->download('xls');
            }
        }
    }

    public function getApprovedList() {
        $getApprovedTestimonials = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')
                ->where('approve_status', '1')
                ->get();

        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($getApprovedTestimonials)) {
            $result = ['success' => true, 'records' => $getApprovedTestimonials, 'exportData' => $export];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function manageTestimonialApproveExportToExcel() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getApprovedTestimonials = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')
                    ->where('approve_status', '1')
                    ->get();

            $getCount = WebTestimonials::select('approve_status', 'company_name', 'customer_name', 'mobile_number', 'testimonial_id')
                    ->where('approve_status', '1')
                    ->get()
                    ->count();
            $getApprovedTestimonials = json_decode(json_encode($getApprovedTestimonials), true);
            $testimonialData = array();
            $j = 1;
            for ($i = 0; $i < count($getApprovedTestimonials); $i++) {

                $testimonial['Sr No.'] = $j++;
                $testimonial['Customer Name'] = $getApprovedTestimonials[$i]['customer_name'];
                $testimonial['Mobile Number'] = $getApprovedTestimonials[$i]['mobile_number'];
                $testimonial['Company Name'] = $getApprovedTestimonials[$i]['company_name'];
                if ($getApprovedTestimonials[$i]['approve_status'] == '1') {
                    $testimonial['Status'] = 'Approved';
                } else {
                    $testimonial['Status'] = 'Not Approve';
                }
                $testimonialData[] = $testimonial;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Testimonial Details', function($excel) use($testimonialData) {
                    $excel->sheet('sheet1', function($sheet) use($testimonialData) {
                        $sheet->fromArray($testimonialData);
                    });
                })->download('xls');
            }
        }
    }

    public function getTestimonialData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getTestimonials = WebTestimonials::where('testimonial_id', $request['testimonial_id'])->first();

        if (!empty($getTestimonials)) {
            $result = ['success' => true, 'records' => $getTestimonials];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function store() {
        $validationRules = WebTestimonials::validationRules();
        $validationMessages = WebTestimonials::validationMessages();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['testimonial'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        $s3FolderName = '/Testimonial/';
        $fileName = 'testimonial_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['photo_url']->getClientOriginalExtension();
        S3::s3FileUpload($input['photo_url']->getPathName(), $fileName, $s3FolderName);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);

        $input['testimonialsData'] = array_merge($input['testimonial'], $create);
        $input['testimonialsData']['photo_url'] = $fileName;
        $insertData = WebTestimonials::create($input['testimonialsData']);
        if ($insertData) {
            $result = ['success' => true, "records" => $insertData];
        } else {
            $result = ['success' => true, "records" => "Something went wrong"];
        }
        return json_encode($result);
    }

    public function edit($id) {
        return view("Testimonials::update")->with("testimonialId", $id);
    }

    public function update($id) {
        $validationRules = WebTestimonials::validationRules1();
        $validationMessages = WebTestimonials::validationMessages1();

        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input['testimonial'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (is_object($input['photo_url'])) {
            $originalName = $input['photo_url']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $fileName = $input['photo_url']->getClientOriginalExtension();
                $s3FolderName = '/Testimonial/';
//                $getOldPhoto = WebTestimonials::select('photo_url')->where('testimonial_id', $id)->get();
//                $path = $s3FolderName . $getOldPhoto[0]['photo_url'];
//                S3::s3FileDelete($path);
                $imageName = "testimonial_" . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $fileName;

                S3::s3FileUpload($input['photo_url']->getPathName(), $imageName, $s3FolderName);
                $fileName = trim($imageName, ",");

                $input['testimonial']['photo_url'] = $imageName;
            } else {
                unset($input['testimonial']['photo_url']);
            }
        }



        unset($input['_method']);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['testimonialsData'] = array_merge($input['testimonial'], $update);
        $updateTestimonials = WebTestimonials::where('testimonial_id', $input['testimonial_id'])->update($input['testimonialsData']);

        $result = ['success' => true, "records" => $input['testimonialsData']];
        echo json_encode($result);
    }

}
