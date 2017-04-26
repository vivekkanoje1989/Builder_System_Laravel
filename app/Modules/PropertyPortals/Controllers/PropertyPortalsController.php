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
        // $validationMessages = Employee::validationMessages();
        //$validationRules = Employee::validationRules();
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
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
