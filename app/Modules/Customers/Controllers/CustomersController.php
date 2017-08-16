<?php

namespace App\Modules\Customers\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Customers\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Validator;
use App\Classes\CommonFunctions;
use App\Classes\S3;

class CustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("Customers::index");
    }

    public function manageCustomer() {
//        $result = Customers::select('*')->with('getTitle', 'getProfession', 'getSource')->orderBy('id', 'ASC')->get();
      
        $result = Customers::select('id','first_name', 'last_name', 'sms_privacy_status', 'email_privacy_status', 'title_id', 'source_id', 'profession_id')->with('getTitle', 'getProfession', 'getSource')->orderBy('id', 'ASC')->get();
       $customerDetails = array();
        for ($i = 0; $i < count($result); $i++) {
            $customerData['id'] = $result[$i]['id'];
            $customerData['firstName'] = $result[$i]['first_name'].' '.$result[$i]['last_name'];
            $customerData['profession'] = $result[$i]['getProfession']['profession'];
            $customerData['title'] = $result[$i]['getTitle']['title'];
            $customerData['sales_source_name'] = $result[$i]['getSource']['sales_source_name'];
            $customerData['sms_privacy_status'] = $result[$i]['sms_privacy_status'];
            $customerData['email_privacy_status'] = $result[$i]['email_privacy_status'];
            $customerDetails[] = $customerData;
        }
        if (!empty($customerDetails)) {
            return json_encode(['result' => $customerDetails, 'status' => true]);
        } else {
            return json_encode(['mssg' => 'No records found', 'status' => false]);
        }
    }

    public function getcustomerData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = Customers::where('id', $request['id'])->first();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['mssg' => 'No record found', 'status' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        $validationRules = Customers::validationRules();
        $validationMessages = Customers::validationMessages();
        $input = Input::all();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($input, $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }
        if (!empty($input['cust_image_file'])) {
            $originalName = $input['cust_image_file']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $s3FolderName = "Customer";
                $imageName = 'customer_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['cust_image_file']->getClientOriginalExtension();
                S3::s3FileUpload($input['cust_image_file']->getPathName(), $imageName, $s3FolderName);
                $image_file = $imageName;
                unset($input['cust_image_file']);
            } else {
                unset($input['cust_image_file']);
            }
        }
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['customerData'] = array_merge($input, $create);
        if (!empty($image_file)) {
            $input['customerData']['image_file'] = $image_file;
        }
        $input['customerData']['client_id'] = $loggedInUserId;
        $result = Customers::where('id', $input['id'])->update($input['customerData']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        return view("Customers::edit")->with("custId", $id);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
