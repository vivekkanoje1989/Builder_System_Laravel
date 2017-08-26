<?php

namespace App\Modules\PropertyPortals\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\PropertyPortals\Models\MlstBmsbPropertyPortal;
use App\Models\backend\Employee;
use App\Modules\PropertyPortals\Models\LstPropertyPortalsProjectConfig;
use App\Classes\CommonFunctions;
use App\Modules\PropertyPortals\Models\LstPropertyPortalsConfig;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Classes\S3;

/* created By- Uma Shinde
 * Date- 14/3/2017
 * updated by-
 */

class PropertyPortalsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("PropertyPortals::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    public function createAccount($id) {
        return view('PropertyPortals::createPortalAccount')->with(array('portalTypeId' => $id, 'portalAccountId' => '0'));
    }

    public function actionPortalAccount() {
        $validationMessages = LstPropertyPortalsConfig::validationMessages();
        $validationRules = LstPropertyPortalsConfig::validationRules();
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        if ($obj['portalData']['enquiry_alocation_types'] == '0') {
            $validationMessages = LstPropertyPortalsConfig::validationMessages1();
            $validationRules = LstPropertyPortalsConfig::validationRules1();
        }
        
         $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($obj['portalData'], $validationRules, $validationMessages);
            
            if ($validator->fails()) {
               
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if ($obj['portalAccountId'] > 0) {            //edit
            if (!empty($obj['portalData']['loggedInUserId'])) {
                $loggedInUserId = $obj['portalData']['loggedInUserId'];
            } else {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            }
            if ($obj['portalData']['enquiry_alocation_types'] == 0) {
                $obj['portalData']['employee_id'] = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $obj['portalData']['employee_id']));
            } else {
                $obj['portalData']['employee_id'] = 1;
            }
            $obj['portalData']['property_portal_id'] = $obj['portalTypeId'];
            $obj['portalData']['project_id'] = 1;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $obj['portalData'] = array_merge($obj['portalData'], $update);
            $updatePortal = LstPropertyPortalsConfig::where('id', $obj['portalAccountId'])->update($obj['portalData']);

            if (!empty($obj['aliasData'])) {
                foreach ($obj['aliasData'] as $updatealias) {
                    if (array_key_exists('project_employee_id', $updatealias)) {
                        $updatealias['project_employee_id'] = (!empty($updatealias['project_employee_id'])) ? $updatealias['project_employee_id'] : 1;
                    } else {
                        $updatealias['project_employee_id'] = 1;
                    }

                    unset($updatealias['project_employee_name']);
                    if (array_key_exists('id', $updatealias)) {
                        $updatealias = array_merge($updatealias, $update);
                        // print_r($updatealias);exit;
                        unset($updatealias['project_employee_id']);
                        $updatePortalAlias = LstPropertyPortalsProjectConfig::where([['id', $updatealias['id']], ['property_portal_id', $obj['portalData']['id']]])->update($updatealias);
                    } else {
                        echo"new";
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $updatealias = array_merge($updatealias, $create);
                        $updatealias['property_portal_id'] = $obj['portalData']['property_portal_id'];
                        $updatealias['property_portal_config_id'] = $obj['portalData']['id'];
                        $updatePortalAlias = LstPropertyPortalsProjectConfig::create($updatealias);
                    }
                }
            }
            $result = ['success' => true, 'message' => 'Account updated successfully'];
            echo json_encode($result);
        } else {                 //create            
            if (!empty($obj['portalData']) && !empty($obj['aliasData'])) {
                if (!empty($obj['portalData']['loggedInUserId'])) {
                    $loggedInUserId = $obj['portalData']['loggedInUserId'];
                } else {
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                }
                if ($obj['portalData']['enquiry_alocation_types'] == 0) {
                    $obj['portalData']['employee_id'] = implode(',', array_map(function($el) {
                                return $el['id'];
                            }, $obj['portalData']['employee_id']));
                } else {
                    $obj['portalData']['employee_id'] = 1;
                }
                $obj['portalData']['property_portal_id'] = $obj['portalTypeId'];
                $obj['portalData']['project_id'] = 1;
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $obj['portalData'] = array_merge($obj['portalData'], $create);
                $createPortal = LstPropertyPortalsConfig::create($obj['portalData']);
                if ($createPortal) {
                    foreach ($obj['aliasData'] as $createalias) {
                        if (array_key_exists('project_employee_id', $createalias)) {
                            $createalias['project_employee_id'] = (!empty($createalias['project_employee_id'])) ? $createalias['project_employee_id'] : 1;
                        } else {
                            $createalias['project_employee_id'] = 1;
                        }
                        $createalias['property_portal_config_id'] = $createPortal->id;
                        $createalias['property_portal_id'] = $createPortal->property_portal_id;
                        $createalias = array_merge($createalias, $create);
                        unset($createalias['project_employee_name']);
                        $cretePortalAlias = LstPropertyPortalsProjectConfig::create($createalias);
                    }
                    if ($cretePortalAlias) {
                        $result = ['success' => true, 'message' => 'Account Added successfully'];
                        echo json_encode($result);
                    }
                } else {
                    $result = ['success' => false, 'message' => 'Something went wrong'];
                    echo json_encode($result);
                }
            }
        }
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

    public function updatePortalAccount($portalTypeId, $accountTypeId) {
        //$accountdata = LstPropertyPortalsConfig::where([['id','=', $accountTypeId],['property_portal_id','=',$portalTypeId]])->get();
        return view('PropertyPortals::updatePortalAccount')->with(array('portalTypeId' => $portalTypeId, 'portalAccountId' => $accountTypeId));
        // echo"<pre>";print_r($accountdata[0]->portal_name);exit;
        //return view('PropertyPortals::updatePortalAccount')->with(array('portalTypeId' => $portalTypeId, 'portalAccountId' => $accountTypeId,'portal_name' =>$accountdata[0]->portal_name,
        //  'username'=>$accountdata[0]->username,'password'=>$accountdata[0]->password,'api_key' => $accountdata[0]->api_key,'assign_employee' => $accountdata[0]->assign_employee));
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

    public function changePortalTypeStatus() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        $updateStatus = MlstBmsbPropertyPortal::where('id', $obj['Data']['id'])->update(['status' => $obj['Data']['status']]);
        if ($updateStatus) {
            $result = ['success' => true, 'message' => 'updates Successfully'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function changePortalAccountStatus() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        $updateStatus = LstPropertyPortalsConfig::where('id', $obj['Data']['id'])->update(['status' => $obj['Data']['status']]);
        if ($updateStatus) {
            $result = ['success' => true, 'message' => 'updates Successfully'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
    }

    public function getupdatePortalAccount() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        $accountdata = LstPropertyPortalsConfig::where([['id', '=', $obj['Data']['portalAccountId']], ['property_portal_id', '=', $obj['Data']['portalTypeId']]])->get();
        $ids = explode(',', '' . $accountdata[0]['employee_id']);
        $getemployee = Employee::whereIn('id', $ids)->select('id', 'first_name', 'last_name')->get();
        $accountdata[0]['employee_id'] = $getemployee;
        if ($accountdata) {
            $result = ['success' => true, 'records' => $accountdata];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function properyPortalAccount() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        //echo ''.$obj['Data']['id'];exit;
        $portalName = LstPropertyPortalsConfig::where('id', $obj['Data']['id'])->get();
        $portalAccounts = LstPropertyPortalsConfig::where('property_portal_id', $obj['Data']['id'])->get();
        foreach ($portalAccounts as $user) {

            $getEmpName = array();
            $empname = Employee::select('first_name', 'last_name')->whereRaw("id IN($user->employee_id)")->get();
            for ($i = 0; $i < count($empname); $i++) {
                $getEmpName[] = $empname[$i]->first_name . '' . $empname[$i]->last_name;
            }
            $implodeEmp = implode(",", $getEmpName);
            $user->employee_id = $implodeEmp;
        }
        $result = ['success' => true, 'records' => $portalAccounts, 'portalName' => $portalName];
        echo json_encode($result);
    }

    public function showPortalAccounts($id) {
        // $portalName = PropertyPortalsType::where('id',$obj['Data']['id'])->get();
        return view('PropertyPortals::indexPortalAccount')->with("accountid", $id);
    }

    public function getProperyAlias() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        if ($obj['Data']['id'] === 0) {   //show all alias
            $portalAlias = LstPropertyPortalsProjectConfig::where('property_portal_config_id', $obj['Data']['portalId'])->get();
        } else { // get alias for update modal
            $portalAlias = LstPropertyPortalsProjectConfig::where([
                        ['property_portal_config_id', '=', $obj['Data']['portalId']],
                        ['id', '=', $obj['Data']['id']],
                        ['property_portal_id', '=', $obj['Data']['portalTypeId']]
                    ])->get();
            $arr = explode(',', $portalAlias[0]['project_employee_id']);
            $portalAlias[0]['project_employee_id'] = Employee::whereIn('id', $arr)->select('id', 'first_name', 'last_name')->get();
            //print_r($portalAlias[0]['project_employee_id']);exit;
        }
        if ($portalAlias) {
            $result = ['success' => true, 'records' => $portalAlias];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($result);
        }
    }

    public function getAllEmployees() {
        $getEmployees = Employee::select('id', 'first_name', 'last_name')->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
