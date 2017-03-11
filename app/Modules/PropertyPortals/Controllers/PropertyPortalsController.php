<?php

namespace App\Modules\PropertyPortals\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PropertyPortalsType;
use App\Models\PropertyPortal;
use App\Models\backend\Employee;
use Illuminate\Http\Request;

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
        $updateStatus = PropertyPortalsType::where('id', $obj['Data']['id'])->update(['status' => $obj['Data']['status']]);
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
        $updateStatus = PropertyPortal::where('id', $obj['Data']['id'])->update(['status' => $obj['Data']['status']]);
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

    public function properyPortalAccount() {
        $postdata = file_get_contents('php://input');
        $obj = json_decode($postdata, true);
        //echo ''.$obj['Data']['id'];exit;
        $portalName = PropertyPortalsType::where('id', $obj['Data']['id'])->get();
        $portalAccounts = PropertyPortal::where('property_portal_type_id', $obj['Data']['id'])->get();
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

    public function showAccounts($id) {
        // $portalName = PropertyPortalsType::where('id',$obj['Data']['id'])->get();
        return view('PropertyPortals::indexPortalAccount')->with("accountid", $id);
    }
    public function createAccount($id)
    {
        return view('PropertyPortals::createPortalAccount')->with("portalTypeId", $id);
    }

}
