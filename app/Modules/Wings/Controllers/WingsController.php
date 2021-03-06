<?php
namespace App\Modules\Wings\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Wings\Models\ProjectWing;
use App\Modules\Projects\Models\Project;
use Validator;
use App\Classes\CommonFunctions;
use Auth;
use DB;
use Excel;

class WingsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("Wings::index")->with('id', -1);
    }

    public function getWingList() {
        // $list = Project::with('wings')->find(1)->toArray();
        // echo json_encode($list);exit;
        //$list = ProjectWing::where('id',1)->select('*',DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y") as created_at'))->get();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['id'] === -1) {
            $list = ProjectWing::select("*")->with('projectName','stationaryName','companyName')->where('deleted_status','!=',1)->get();
            
            $i=0;
            foreach($list as $lists){
                $list[$i]['project']=$lists['projectName']['project_name'];
                $list[$i]['company']=$lists['companyName']['legal_name'];
                $list[$i]['stationary']=$lists['stationaryName']['stationary_set_name'];
                $i++;
            }
            
        } else {
            $list = ProjectWing::where('id', $input['id'])->get();
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
        if (!empty($list)) {
            $result = ['success' => true, 'records' => $list,'exportData'=>$export,'deletePermission'=>$deleteBtn];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'No Wings Records'];
            return json_encode($result);
        }
    }
    
    
     public function projectWingsExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $wings = ProjectWing::select("*")->with('projectName','stationaryName','companyName')->where('deleted_status','!=',1)->get();
            $getCount = ProjectWing::select("*")->with('projectName','stationaryName','companyName')->where('deleted_status','!=',1)->get()->count();
            $wings = json_decode(json_encode($wings), true);
            

            $manageWings = array();
            $j = 1;
            for ($i = 0; $i < count($wings); $i++) {
                $wingData['Sr. No.'] = $j++;
                $wingData['Project Name'] = $wings[$i]['project_name']['project_name'];
                $wingData['Wing Name'] = $wings[$i]['wing_name'];
                $wingData['Company'] = $wings[$i]['company_name']['legal_name'];
                $wingData['Stationary'] = $wings[$i]['stationary_name']['stationary_set_name'];
                $wingData['Floors'] = $wings[$i]['number_of_floors'];
                $manageWings[] = $wingData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Project Wing Details', function($excel) use($manageWings) {
                    $excel->sheet('sheet1', function($sheet) use($manageWings) {
                        $sheet->fromArray($manageWings);
                    });
                })->download('csv');
            }
        }
    }
    
     public function deleteWing() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        if (!empty($request['loggedInUserID'])) {
            $loggedInUserId = $request['loggedInUserID'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        unset($request['loggedInUserID']);
        $input['wingData'] = array_merge($request, $create);
        $careers = ProjectWing::where('id', $request['id'])->update($input['wingData']);
        $result = ['success' => true, 'result' => $careers];
        return json_encode($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("Wings::create")->with('id', 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = ProjectWing::validationMessages();
        $validationRules = ProjectWing::validationRules();
        $validator = Validator::make($input['wingData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result, true);
            exit;
        }
        if (!empty($input['wingData']['loggedInUserId'])) {
            $loggedInUserId = $input['wingData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['wingData'] = array_merge($input['wingData'], $create);
        $createWings = ProjectWing::create($input['wingData']);
        if ($createWings) {
            $result = ['success' => true, 'message' => 'Wing Created Successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Wing Not Created'];
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
    public function edit($id) {
        return view("Wings::create")->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = ProjectWing::validationMessages();
        $validationRules = ProjectWing::validationRules();
        $validator = Validator::make($input['wingData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result, true);
            exit;
        }
        if (!empty($input['wingData']['loggedInUserId'])) {
            $loggedInUserId = $input['wingData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['wingData'] = array_merge($input['wingData'], $update);
        $updateWings = ProjectWing::where('id',$id)->update($input['wingData']);
        $result = ['success' => true, 'message' => 'Wing Updated Successfully'];
        return json_encode($result);
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
