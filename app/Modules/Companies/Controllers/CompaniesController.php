<?php

namespace App\Modules\Companies\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Companies\Models\Companies;
use App\Modules\Companies\Models\CompanyStationaries;
use App\Modules\Companies\Models\CompanyDocuments;
use App\Modules\BankAccounts\Models\CompaniesBankaccounts;
use Illuminate\Http\Request;
use Auth;
use App\Classes\CommonFunctions;
use DB;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;

class CompaniesController extends Controller {

    public function index() {
        return view("Companies::index");
    }

    public function create() {
        return view("Companies::create");
    }

    public function edit($companyId) {
        return view("Companies::edit")->with("companyId", $companyId);
    }

    public function manageCompany() {
        $result = companies::select('punch_line','legal_name','id')->get();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => "No record found", 'status' => true]);
        }
    }

    public function manageBankAccount() {
        $result = CompaniesBankaccounts::select('account_number', 'id')->get();
        if (!empty($result)) {
            return json_encode(['records' => $result, 'status' => true]);
        } else {
            return json_encode(['errorMSg' => 'No record found', 'status' => true]);
        }
    }

    public function store() {
        $validationRules = Companies::validationRules();
        $validationMessages = Companies::validationMessages();
        $input = Input::all();
        $cnt = 0;
        if ($cnt > 0) {
            $result = ['status' => false, 'errormsg' => 'Company name already exists'];
            return json_encode($result);
        } else {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
                $validator = Validator::make($input['CompanyData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result, true);
                }
            }
            $s3FolderName = 'Company/firmlogo';
            $imageName = 'company_firm_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['FirmLogo']['FirmLogo']->getClientOriginalExtension();
            S3::s3FileUpload($input['FirmLogo']['FirmLogo']->getPathName(), $imageName, $s3FolderName);
            $name = $imageName;
            $name = trim($name, ",");
            $firm_logo = $name;

            $post['punch_line'] = $input['CompanyData']['punch_line'];
            $post['legal_name'] = $input['CompanyData']['legal_name'];
            $post['firm_logo'] = $firm_logo;
            if (!empty($input['CompanyData']['vat_num'])) {
                $post['vat_number'] = $input['CompanyData']['vat_num'];
            }
            if (!empty($input['CompanyData']['domain_name'])) {
                $post['domain_name'] = $input['CompanyData']['domain_name'];
            } else {
                $post['domain_name'] = '';
            }
            if (!empty($input['CompanyData']['gst_number'])) {
                $post['gst_number'] = $input['CompanyData']['gst_number'];
            } else {
                $post['gst_number'] = '';
            }

            if (!empty($input['CompanyData']['pan_num'])) {
                $post['pan_number'] = $input['CompanyData']['pan_num'];
            }
            if (!empty($input['CompanyData']['service_tax_number'])) {
                $post['service_tax_number'] = $input['CompanyData']['service_tax_number'];
            }
            $post['office_address'] = $input['CompanyData']['office_address'];
            $post['cloud_telephoney_client'] = $input['CompanyData']['cloud_telephoney_client'];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $allData = array_merge($common, $post);
            $companyDetails = Companies::create($allData);
            $company = Companies::latest('id')->first();
            if (!empty($input['stationary']['0']['receipt_letterhead_file']) || !empty($input['stationary']['0']['estimate_letterhead_file']) || !empty($input['stationary']['0']['rubber_stamp_file']) || !empty($input['stationary']['0']['estimate_logo_file']) || !empty($input['stationary']['0']['demandletter_letterhead_file']) || !empty($input['stationary']['0']['demandletter_logo_file']) || !empty($input['stationary']['0']['demandletter_logo_file']) || !empty($input['stationary']['0']['stationary_set_name'])) {

                for ($i = 0; $i < count($input['stationary']); $i++) {
                    if (!empty($input['stationary'][$i]['estimate_letterhead_file'])) {
                        $s3FolderName = 'Company/estimateLetterhead';
                        $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['estimate_letterhead_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['estimate_letterhead_file']->getPathName(), $imageName, $s3FolderName);
                        $letterhead = $imageName;
                    } else {
                        $letterhead = '';
                    }
                    if (!empty($input['stationary'][$i]['receipt_letterhead_file'])) {
                        $s3FolderName1 = 'Company/receiptLetterhead';
                        $imageName1 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['receipt_letterhead_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['receipt_letterhead_file']->getPathName(), $imageName1, $s3FolderName1);
                        $receiptname = $imageName1;
                    } else {
                        $receiptname = '';
                    }
                    if (!empty($input['stationary'][$i]['rubber_stamp_file'])) {
                        $s3FolderName2 = 'Company/rubberStampFile';
                        $imageName2 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['rubber_stamp_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['rubber_stamp_file']->getPathName(), $imageName2, $s3FolderName2);
                        $stampname = $imageName2;
                    } else {
                        $stampname = '';
                    }
                    if (!empty($input['stationary'][$i]['estimate_logo_file'])) {
                        $s3FolderName3 = 'Company/estimateLogoFile';
                        $imageName3 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['estimate_logo_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['estimate_logo_file']->getPathName(), $imageName3, $s3FolderName3);
                        $estLogoFile = $imageName3;
                    } else {
                        $estLogoFile = '';
                    }

                    if (!empty($input['stationary'][$i]['demandletter_letterhead_file'])) {
                        $s3FolderName4 = 'Company/demandletterFile';
                        $imageName4 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['demandletter_letterhead_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['demandletter_letterhead_file']->getPathName(), $imageName4, $s3FolderName4);
                        $demandLetter = $imageName4;
                    } else {
                        $demandLetter = '';
                    }

                    if (!empty($input['stationary'][$i]['demandletter_logo_file'])) {
                        $s3FolderName5 = 'Company/demandletterLogoFile';
                        $imageName5 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['demandletter_logo_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['demandletter_logo_file']->getPathName(), $imageName5, $s3FolderName5);
                        $demandLogoFile = $imageName5;
                    } else {
                        $demandLogoFile = '';
                    }

                    if (!empty($input['stationary'][$i]['receipt_logo_file'])) {
                        $s3FolderName6 = 'Company/receiptLogoFile';
                        $imageName6 = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['receipt_logo_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['stationary'][$i]['receipt_logo_file']->getPathName(), $imageName6, $s3FolderName6);
                        $receiptLogoFile = $imageName6;
                    } else {
                        $receiptLogoFile = '';
                    }
                    if (!empty($input['stationary'][$i]['stationary_set_name'])) {
                        $stationary_set_name = $input['stationary'][$i]['stationary_set_name'];
                    } else {
                        $stationary_set_name = '';
                    }
                    $post = [
                        "stationary_set_name" => $stationary_set_name,
                        "estimate_letterhead_file" => $letterhead,
                        "receipt_letterhead_file" => $receiptname,
                        "rubber_stamp_file" => $stampname,
                        "status" => '1',
                        "estimate_logo_file" => $estLogoFile,
                        "demandletter_logo_file" => $demandLogoFile,
                        "demandletter_letterhead_file" => $demandLetter,
                        "receipt_logo_file" => $receiptLogoFile,
                        "company_id" => $company->id,
                    ];
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                    $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $allData = array_merge($common, $post);
                    $create = CompanyStationaries::create($allData);
                }
            }
            if (!empty($input['documents']['0']['document_file']) || !empty($input['documents']['0']['document_name'])) {

                for ($i = 0; $i < count($input['documents']); $i++) {

                    if (!empty($input['documents'][$i]['document_file'])) {
                        $s3FolderName = 'Company/documents';
                        $imageName = 'company_doc' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['documents'][$i]['document_file']->getClientOriginalExtension();
                        S3::s3FileUpload($input['documents'][$i]['document_file']->getPathName(), $imageName, $s3FolderName);
                        $document_file = $imageName;
                    } else {
                        $document_file = '';
                    }
                    if (!empty($input['documents'][$i]['document_name'])) {
                        $document_name = $input['documents'][$i]['document_name'];
                    } else {
                        $document_name = '';
                    }

                    $post = ['document_name' => $document_name, 'document_file' => $document_file, 'status' => '1'];
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                    $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $allData = array_merge($common, $post);
                    print_r($allData);
                    $allData["company_id"] = $company->id;
                    $create = CompanyDocuments::create($allData);
                }
            }
        }
//        print_r($create);
        return json_encode(['records' => $companyDetails, 'status' => true]);
    }

    public function loadCompanyData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = Companies::where('id', $request['id'])->first();
        $document = CompanyDocuments::where('company_id', $request['id'])->get();
        $stationary = CompanyStationaries::where('company_id', $request['id'])->get();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'documents' => $document, 'stationary' => $stationary, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'No record found', 'status' => true]);
        }
    }

    public function updateCompany() {
         $validationRules = Companies::validationRules();
        $validationMessages = Companies::validationMessages();
        $input = Input::all();
        $cnt = Companies::where(['legal_name' => $input['CompanyData']['legal_name']])->where('id', '!=', $input['id'])->get()->count();
        if ($cnt > 0) {
            $result = ['status' => false, 'errormsg' => 'Company name already exists'];
            return json_encode($result);
        } else {
             $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
                $validator = Validator::make($input['CompanyData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result, true);
                }
            }
            $s3FolderName = 'Company/firmlogo';
            $imageName = 'company_firm_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['FirmLogo']['FirmLogo']->getClientOriginalExtension();
            S3::s3FileUpload($input['FirmLogo']['FirmLogo']->getPathName(), $imageName, $s3FolderName);
            $name = $imageName;
            $name = trim($name, ",");
            $firm_logo = $name;
            if (!empty($input['FirmLogo']['FirmLogo']->getClientOriginalExtension())) {
                $post['firm_logo'] = $firm_logo;
            }
            $post['punch_line'] = $input['CompanyData']['punch_line'];
            $post['legal_name'] = $input['CompanyData']['legal_name'];
            if (!empty($input['CompanyData']['vat_num'])) {
                $post['vat_number'] = $input['CompanyData']['vat_num'];
            }
            if (!empty($input['CompanyData']['domain_name'])) {
                $post['domain_name'] = $input['CompanyData']['domain_name'];
            }
            if (!empty($input['CompanyData']['gst_number'])) {
                $post['gst_number'] = $input['CompanyData']['gst_number'];
            }
            if (!empty($input['CompanyData']['pan_num'])) {
                $post['pan_number'] = $input['CompanyData']['pan_num'];
            }
            if (!empty($input['CompanyData']['service_tax_number'])) {
                $post['service_tax_number'] = $input['CompanyData']['service_tax_number'];
            }

            $post['office_address'] = $input['CompanyData']['office_address'];
            $post['cloud_telephoney_client'] = $input['CompanyData']['cloud_telephoney_client'];
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $allCompanyData = array_merge($common, $post);
            $create = Companies::where('id', '=', $input['id'])->update($allCompanyData);

            if (!empty($input['stationary']['0']['receipt_letterhead_file']) || !empty($input['stationary']['0']['estimate_letterhead_file']) || !empty($input['stationary']['0']['rubber_stamp_file']) || !empty($input['stationary']['0']['estimate_logo_file']) || !empty($input['stationary']['0']['demandletter_letterhead_file']) || !empty($input['stationary']['0']['demandletter_logo_file']) || !empty($input['stationary']['0']['demandletter_logo_file']) || !empty($input['stationary']['0']['stationary_set_name'])) {

                $delete = CompanyStationaries::where('company_id', '=', $input['id'])->delete();
                for ($i = 0; $i < count($input['stationary']); $i++) {
                    if (!empty($input['stationary'][$i]['receipt_letterhead_file']) || !empty($input['stationary'][$i]['estimate_letterhead_file']) || !empty($input['stationary'][$i]['rubber_stamp_file']) || !empty($input['stationary'][$i]['estimate_logo_file']) || !empty($input['stationary'][$i]['demandletter_letterhead_file']) || !empty($input['stationary'][$i]['demandletter_logo_file']) || !empty($input['stationary'][$i]['demandletter_logo_file']) || !empty($input['stationary'][$i]['stationary_set_name'])) {

                        $post = [];
                        if (!empty($input['stationary'][$i]['estimate_letterhead_file'])) {

                            $docFile = is_object($input['stationary'][$i]['estimate_letterhead_file']) ? "1" : "0";
                            if ($docFile == '1') {
                                $s3FolderName = 'Company/estimateLetterhead';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['estimate_letterhead_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['estimate_letterhead_file']->getPathName(), $imageName, $s3FolderName);
                                $letterhead = $imageName;
                                array_push($post, ["estimate_letterhead_file" => $letterhead]);
                            }
                        } else {
                            array_push($post, ["estimate_letterhead_file" => $input['stationary'][$i]['estimateLetterheadFile']]);
                        }


                        if (!empty($input['stationary'][$i]['estimate_logo_file'])) {
                            $docFile = is_object($input['stationary'][$i]['estimate_logo_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/estimateLogoFile';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['estimate_logo_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['estimate_logo_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["estimate_logo_file" => $imageName]);
                            }
                        } else {
                            array_push($post, ["estimate_logo_file" => $input['stationary'][$i]['estimateLogo']]);
                        }


                        if (!empty($input['stationary'][$i]['demandletter_letterhead_file'])) {

                            $docFile = is_object($input['stationary'][$i]['demandletter_letterhead_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/demandletterFile';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['demandletter_letterhead_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['demandletter_letterhead_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["demandletter_letterhead_file" => $imageName]);
                            }
                        } else {
                            array_push($post, ["demandletter_letterhead_file" => $input['stationary'][$i]['demandletterFile']]);
                        }


                        if (!empty($input['stationary'][$i]['demandletter_logo_file'])) {

                            $docFile = is_object($input['stationary'][$i]['demandletter_logo_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/demandletterLogoFile';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['demandletter_logo_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['demandletter_logo_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["demandletter_logo_file" => $imageName]);
                            }
                        } else {
                            array_push($post, ["demandletter_logo_file" => $input['stationary'][$i]['demandletterLogoFile']]);
                        }


                        if (!empty($input['stationary'][$i]['receipt_logo_file'])) {

                            $docFile = is_object($input['stationary'][$i]['receipt_logo_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/receiptLogoFile';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['receipt_logo_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['receipt_logo_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["receipt_logo_file" => $imageName]);
                            } else {
                                array_push($post, ["receipt_logo_file" => $input['stationary'][$i]['receiptLogoFile']]);
                            }
                        }

                        if (!empty($input['stationary'][$i]['receipt_letterhead_file'])) {

                            $docFile = is_object($input['stationary'][$i]['receipt_letterhead_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/receiptLetterhead';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['receipt_letterhead_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['receipt_letterhead_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["receipt_letterhead_file" => $imageName]);
                            }
                        } else {
                            array_push($post, ["receipt_letterhead_file" => $input['stationary'][$i]['receiptLetterhead']]);
                        }
                        if (!empty($input['stationary'][$i]['rubber_stamp_file'])) {

                            $docFile = is_object($input['stationary'][$i]['rubber_stamp_file']) ? "1" : "0";

                            if ($docFile == '1') {
                                $s3FolderName = 'Company/rubberStampFile';
                                $imageName = 'company_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['stationary'][$i]['rubber_stamp_file']->getClientOriginalExtension();
                                S3::s3FileUpload($input['stationary'][$i]['rubber_stamp_file']->getPathName(), $imageName, $s3FolderName);

                                array_push($post, ["rubber_stamp_file" => $imageName]);
                            }
                        } else {
                            array_push($post, ["rubber_stamp_file" => $input['stationary'][$i]['rubberStamp']]);
                        }

                        if (!empty($input['stationary'][$i]['stationary_set_name'])) {
                            $stationary_set_name = $input['stationary'][$i]['stationary_set_name'];
                        } else {
                            $stationary_set_name = '';
                        }
                        $postData = array_reduce($post, 'array_merge', array());
                        $loggedInUserId = Auth::guard('admin')->user()->id;
                        $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $allData = array_merge($common, $postData);
                        $allData['company_id'] = $input['id'];
                        $allData['status'] = '1';
                        $allData['stationary_set_name'] = $stationary_set_name;


                        $create = CompanyStationaries::create($allData);
                    }
                }
            }

            $delete = CompanyDocuments::where('company_id', '=', $input['id'])->delete();
            if (!empty($input['documents']['0']['document_file']) || !empty($input['documents']['0']['document_name'])) {
                for ($i = 0; $i < count($input['documents']); $i++) {
                    $post2 = [];
                    if (!empty($input['documents'][$i]['document_file'])) {
                        $docFile = is_object($input['documents'][$i]['document_file']) ? "1" : "0";

                        if ($docFile == '1') {
                            $s3FolderName = 'Company/documents';
                            $imageName = 'company_doc' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['documents'][$i]['document_file']->getClientOriginalExtension();
                            S3::s3FileUpload($input['documents'][$i]['document_file']->getPathName(), $imageName, $s3FolderName);
                            $document_file = $imageName;
                            array_push($post2, ["document_file" => $document_file]);
                        }
                    } else {
                        array_push($post2, ["document_file" => $input['documents'][$i]['documentFile']]);
                    }



                    if (!empty($input['documents'][$i]['document_name'])) {
                        $document_name = $input['documents'][$i]['document_name'];
                        array_push($post2, ["document_name" => $document_name]);
                    } else {
                        array_push($post2, ["document_name" => '']);
                    }
                    $docData = array_reduce($post2, 'array_merge', array());
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                    $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
                    $allData = array_merge($common, $docData);
                    $allData['company_id'] = $input['id'];
                    $allData['status'] = $input['id'];
                    $create = CompanyDocuments::create($allData);
                }
            }
            //}
            return json_encode(['result' => $allCompanyData, 'status' => true]);
        }
    }

}
