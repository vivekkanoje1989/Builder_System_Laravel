<?php
namespace App\Http\Controllers\backend\hr;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Model\backend\Employee;

class HrController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function index(Request $request)
    {
        $products= Employee::orderBy('id','DESC')->paginate(5);
        return view('backend.hr.user',compact('products'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        return view("backend.hr.user");
    }    
    
    public function store(Request $request)
    {
        $messages = array(
            'username.required' => 'Please enter user name',
            'password.required' => 'Please enter password',
            'designation.required' => 'Please enter designation',
            'department_id.required' => 'Please enter department',
            'reporting_to_id.required' => 'Please enter reporting to',
            'title_id.required' => 'Please enter title',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'date_of_birth.required' => 'Please enter birth date',
            'gender_id.required' => 'Please enter gender',
            'marital_status.required' => 'Please enter marital status',
            'physic_status_id.required' => 'Please enter physic status',
            'personal_mobile_no1' => ['required' => 'Please enter personal mobile number', 'numeric' => 'Please enter only digits', 'max' => 'Mobile number must be 10 digits only'],
            'office_mobile_no' => ['required' => 'Please enter office mobile number', 'numeric' => 'Please enter only digits', 'max' => 'Mobile number must be 10 digits only'],
            'current_country_id.required' => 'Please enter current country',
            'current_state_id.required' => 'Please enter current state',
            'current_city_id.required' => 'Please enter current city',
            'current_pin.required' => 'Please enter current pin code',
            'current_address.required' => 'Please enter current address',
            'permenent_country_id.required' => 'Please enter permenent country',
            'permenent_state_id' => 'Please enter permenent state',
            'permenent_city_id' => 'Please enter permenent city',
            'permenent_pin' => 'Please enter permenent pin code',
            'permenent_address' => 'Please enter permenent address',
            'highest_education_id' => 'Please enter highest education',
            'emp_photo_url' => 'Please select photo',
            'joining_date' => 'Please enter joining date'
        );
        $rules = array(
            'username' => 'required',
            'password' => 'required|max:12',
            'usertype' => 'required',
            'designation' => 'required',
            'department_id' => 'required',
            'reporting_to_id' => 'required',
            'title_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'gender_id' => 'required',
            'marital_status' => 'required',
            'blood_group_id' => 'required',
            'physic_status_id' => 'required',
            'personal_mobile_no1' => 'required|numeric|max:10',
            'office_mobile_no' => 'numeric|max:10',
            'email' => 'required|email|unique:employees',
            'personal_email_id' => 'email',
            'office_email_id' => 'email',
            'current_country_id' => 'required',
            'current_state_id' => 'required',
            'current_city_id' => 'required',
            'current_pin' => 'required',
            'current_address' => 'required',
            'permenent_country_id' => 'required',
            'permenent_state_id' => 'required',
            'permenent_city_id' => 'required',
            'permenent_pin' => 'required',
            'permenent_address' => 'required',
            'highest_education_id' => 'required',
            'emp_photo_url' => 'required',
            'joining_date' => 'required|date|date_format:Y-m-d',
        );
        
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata,true);
        
        $validator = Validator::make($request['data'], $rules, $messages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }  
        
        exit;
//        Employee::create($request->all());
    }
    
}