<?php

namespace App\Modules\CareerManagement\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\CareerManagement\Models\WebCareers;
use App\Classes\CommonFunctions;
use Auth;
use Excel;
use DB;
use Validator;
use App\Modules\CareerManagement\Models\WebCareersApplications;
use Illuminate\Support\Facades\Input;

class CareerManagementController extends Controller {

    public function index() {
        return view("CareerManagement::index");
    }

    public function create() {
        return view("CareerManagement::create");
    }

    public function store() {

        $validationRules = WebCareers::validationRules();
        $validationMessages = WebCareers::validationMessages();

        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($request, $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (!empty($request['loggedInUserID']))
            $loggedInUserId = $request['loggedInUserID'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['careerData'] = array_merge($request, $create);
        $careers = WebCareers::create($input['careerData']);
        $last3 = WebCareers::latest('id')->first();
        $result = ['success' => true, 'result' => $careers, 'lastinsertid' => $last3->id];
        return json_encode($result);
    }

    public function viewapplicants() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $export = '';
        $query='';
        if (isset($request['pageNumber'])) {
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            if (!empty($request['filterData'])) {
                $request['filterData']['first_name'] = !empty($request['filterData']) ? $request['filterData'][0]['first_name'] : '';
                $request['filterData']['last_name'] = !empty($request['filterData']) ? $request['filterData'][0]['last_name'] : '';
                $request['filterData']['mobile_number'] = !empty($request['filterData'][0]['mobile_number']) ? $request['filterData'][0]['mobile_number'] : '';
                $request['filterData']['email_id'] = !empty($request['filterData'][0]['email_id']) ? $request['filterData'][0]['email_id'] : '';

                if (!empty($request['filterData']['first_name'])) {
                    $query .= " first_name like '%" . $request['filterData']['first_name'] . "%'";
                }
                if (!empty($request['filterData']['last_name'])) {
                    if ($query !== '')
                        $query .= " AND last_name like '%" . $request['filterData']['last_name'] . "%'";
                    else
                        $query .= " last_name like '%" . $request['filterData']['last_name'] . "%'";
                }
                if (!empty($request['filterData']['mobile_number'])) {
                    if ($query !== '')
                        $query .= " AND mobile_number = '" . $request['filterData']['mobile_number'] . "'";
                    else
                        $query .= " mobile_number = '" . $request['filterData']['mobile_number'] . "'";
                }
                if (!empty($request['filterData']['email_id'])) {
                    if ($query != '')
                        $query .= " AND email_id = '" . $request['filterData']['email_id'] . "'";
                    else
                        $query .= " email_id = '" . $request['filterData']['email_id'] . "'";
                }

                $careers = WebCareersApplications::select([DB::raw('SQL_CALC_FOUND_ROWS id, mobile_number,email_id,first_name,last_name')])
                        ->where([['career_id', $request['career_id']], ['deleted_status', '!=', 1]])
                        ->whereRaw($query)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            } else {
                $careers = WebCareersApplications::select([DB::raw('SQL_CALC_FOUND_ROWS id, mobile_number,email_id,first_name,last_name')])
                        ->where([['career_id', $request['career_id']], ['deleted_status', '!=', 1]])
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            }
            $rows = DB::select("select FOUND_ROWS() as totalCount");
            $cnt = $rows[0]->totalCount;
        } else {
            $careers = WebCareersApplications::where([['career_id', $request['career_id']], ['deleted_status', '!=', 1]])->get();
            $cnt = '';
        }


        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
            if (in_array('01401', $array)) {
                $export = 1;
            }
        }
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers, 'exportApplicationData' => $export, 'totalCount' => $cnt];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function manageCareers() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $export = $deleteBtn = $query = '';
        if (!empty($request['loggedInUserID'])) {
            $loggedInUserId = $request['loggedInUserID'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        if (isset($request['pageNumber'])) {
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            if (!empty($request['filterData'])) {
                $request['filterData']['job_title'] = !empty($request['filterData']) ? $request['filterData'][0]['job_title'] : '';
                $request['filterData']['application_start_date'] = !empty($request['filterData'][0]['application_start_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['application_start_date'])) : '';
                $request['filterData']['application_close_date'] = !empty($request['filterData'][0]['application_close_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['application_close_date'])) : '';

                if (!empty($request['filterData']['job_title'])) {
                    $query .= " job_title like '%" . $request['filterData']['job_title'] . "%'";
                }
                if (!empty($request['filterData']['application_start_date'])) {
                    if ($query !== '')
                        $query .= " AND application_start_date = '" . $request['filterData']['application_start_date'] . "'";
                    else
                        $query .= " application_start_date = '" . $request['filterData']['application_start_date'] . "'";
                }
                if (!empty($request['filterData']['application_close_date'])) {
                    if ($query != '')
                        $query .= " AND application_close_date = '" . $request['filterData']['application_close_date'] . "'";
                    else
                        $query .= " application_close_date = '" . $request['filterData']['application_close_date'] . "'";
                }

                $careers = WebCareers::select([DB::raw('SQL_CALC_FOUND_ROWS id, job_title, application_close_date, application_start_date, job_locations,job_eligibility, job_responsibilities, job_role, number_of_positions, approved_by')])
                        ->where('deleted_status', '!=', 1)
                        ->whereRaw($query)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            } else {
                $careers = WebCareers::select([DB::raw('SQL_CALC_FOUND_ROWS id, job_title, application_close_date, application_start_date, job_locations,job_eligibility, job_responsibilities, job_role, number_of_positions, approved_by')])
                        ->where('deleted_status', '!=', 1)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            }
            $rows = DB::select("select FOUND_ROWS() as totalCount");
            $cnt = $rows[0]->totalCount;
        } else {
            $careers = WebCareers::select('id', 'job_title', 'application_close_date', 'application_start_date', 'job_locations', 'job_eligibility', 'job_responsibilities', 'job_role', 'number_of_positions', 'approved_by')
                    ->where('deleted_status', '!=', 1)
                    ->get();
            $cnt = '';
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
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
        }
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers, 'exportData' => $export, 'delete' => $deleteBtn, 'totalCount' => $cnt];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function jobPostingExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $careers = WebCareers::where('deleted_status', '!=', 1)->get();
            $getCount = WebCareers::where('deleted_status', '!=', 1)->get()->count();
            $careers = json_decode(json_encode($careers), true);

            $manageCareers = array();
            $j = 1;
            for ($i = 0; $i < count($careers); $i++) {
                $careerData['Sr No.'] = $j++;
                $careerData['Job Title'] = $careers[$i]['job_title'];
                $careerData['Job Eligibility'] = preg_replace("/\r|\n/", "", $careers[$i]['job_eligibility']);
                $careerData['Application Start Date'] = $careers[$i]['application_start_date'];
                $careerData['Application Close Date'] = $careers[$i]['application_close_date'];
                $manageCareers[] = $careerData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Job Posting Details', function($excel) use($manageCareers) {
                    $excel->sheet('sheet1', function($sheet) use($manageCareers) {
                        $sheet->fromArray($manageCareers);
                    });
                })->download('csv');
            }
        }
    }

    public function getCareer() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $careers = WebCareers::where('id', $request['id'])->first();
        if (!empty($careers)) {
            $result = ['success' => true, 'records' => $careers];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function edit($id) {
        return view("CareerManagement::update")->with("id", $id);
    }

    public function deleteJob() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        if (!empty($request['loggedInUserID'])) {
            $loggedInUserId = $request['loggedInUserID'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        unset($request['loggedInUserID']);
        $input['careerData'] = array_merge($request, $create);
        $careers = WebCareers::where('id', $request['id'])->update($input['careerData']);
        $result = ['success' => true, 'result' => $careers];
        return json_encode($result);
    }

    public function update($id) {
        $validationRules = WebCareers::validationRules();
        $validationMessages = WebCareers::validationMessages();

        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($request, $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }

        if (!empty($request['loggedInUserID']))
            $loggedInUserId = $request['loggedInUserID'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);

        unset($request['loggedInUserID']);
        if (!empty($request['$$hashKey'])) {
            unset($request['$$hashKey']);
        }
        $input['careerData'] = array_merge($request, $create);

        $careers = WebCareers::where('id', $id)->update($input['careerData']);
        $result = ['success' => true, 'result' => $careers];
        return json_encode($result);
    }

    public function show($id) {

        return view("CareerManagement::show")->with("career_id", $id);
    }

    public function jobPostingApplicationExportToxls($career_id) {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $careers = WebCareersApplications::where('career_id', $career_id)
                            ->where('deleted_status', '!=', 1)->get();
            $getCount = WebCareersApplications::where('career_id', $career_id)
                            ->where('deleted_status', '!=', 1)->get()->count();
            $careers = json_decode(json_encode($careers), true);
            $manageCareers = array();
            $j = 1;
            for ($i = 0; $i < count($careers); $i++) {
                $careerData['Sr No.'] = $j++;
                $careerData['First Name'] = $careers[$i]['first_name'];
                $careerData['Last Name'] = $careers[$i]['last_name'];
                $careerData['Mobile Number'] = $careers[$i]['mobile_number'];
                $careerData['Email'] = $careers[$i]['email_id'];
                $manageCareers[] = $careerData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Job Posting Details', function($excel) use($manageCareers) {
                    $excel->sheet('sheet1', function($sheet) use($manageCareers) {
                        $sheet->fromArray($manageCareers);
                    });
                })->download('csv');
            }
        }
    }

    public function download($file_name) {
        $file_path = public_path('resumes/' . $file_name);
        return response()->download($file_path);
    }

}
