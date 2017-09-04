<?php

namespace App\Modules\BankAccounts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\BankAccounts\Models\CompaniesBankaccounts;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use Auth;
use App\Modules\PaymentHeadings\Models\LstDlPaymentHeadings;
use App\Modules\Companies\Models\Companies;

class BankAccountsController extends Controller {

    public function index() {
        return view("BankAccounts::index");
    }

    public function managePaymentHeading() {
        $getPayment = LstDlPaymentHeadings::select('id', 'payment_heading')->get();

        if (!empty($getPayment)) {
            $result = ['success' => true, 'records' => $getPayment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getCompany() {
        $getCompanies = Companies::select('id', 'legal_name')->get();

        if (!empty($getCompanies)) {
            $result = ['success' => true, 'records' => $getCompanies];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['bankAccount'] = array_merge($request, $create);
        $result = CompaniesBankaccounts::create($input['bankAccount']);
        $last = CompaniesBankaccounts::latest('id')->first();
        $company = Companies::where('id', $request['company_id'])->first();

        if (!empty($result)) {
            return json_encode(['result' => $result, 'lastId' => $last->id, 'company' => $company->legal_name, 'success' => true]);
        } else {
            return json_encode(['result' => $result, 'success' => false]);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['bankAccount'] = array_merge($request, $create);
        $result = CompaniesBankaccounts::where('id', '=', $id)->update($input['bankAccount']);
        
        $company = Companies::where('id', $request['company_id'])->first();

        if (!empty($result)) {
            return json_encode(['result' => $result, 'company' => $company->legal_name, 'success' => true]);
        } else {
            return json_encode(['result' => $result, 'success' => false]);
        }
    }

    public function manageBankAccount() {
        $result = CompaniesBankaccounts::join('companies', 'companies.id', '=', 'companies_bankaccounts.company_id')->select(['companies_bankaccounts.id','companies_bankaccounts.company_id','companies_bankaccounts.name','companies_bankaccounts.branch',
                'companies_bankaccounts.ifsc','companies_bankaccounts.micr','companies_bankaccounts.account_number','companies_bankaccounts.account_type','companies_bankaccounts.address'
                ,'companies_bankaccounts.phone','companies_bankaccounts.email','companies_bankaccounts.preffered_payment_headings_ids','companies.legal_name'])->get();
        if (!empty($result)) {
            return json_encode(['records' => $result, 'status' => true]);
        } else {
            return json_encode(['errorMSg' => 'No record found', 'status' => true]);
        }
    }

    public function paymentHeadingFiltered() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);


        $filter = explode(',', $request['payment_headings']);
        $result = LstDlPaymentHeadings::select('payment_heading', 'id')->whereNotIn('id', $filter)->get();

        if (!empty($result)) {
            return json_encode(['records' => $result, 'status' => true]);
        } else {
            return json_encode(['errorMSg' => 'No record found', 'status' => true]);
        }
    }

    public function paymentHeadingEdit() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $resultArray = [];
        if (!empty($request['payment_headings'])) {
            $ids = explode(',', $request['payment_headings']);

            for ($i = 0; $i < count($ids); $i++) {
                $result = LstDlPaymentHeadings::where('id', $ids[$i])->select('payment_heading', 'id')->first();
                array_push($resultArray, ['id' => $result->id, 'payment_heading' => $result->payment_heading]);
            }
            return json_encode(['records' => $resultArray, 'success' => true]);
        } else {
            return json_encode(['errorMsg' => 'No record found', 'success' => true]);
        }
    }

}
