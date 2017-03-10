<?php namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Models\EnquiryLostReason;
use App\Http\Controllers\Controller;
use DB;
use App\Classes\CommonFunctions;
use Illuminate\Http\Request;


class LostReasonsController extends Controller {	
    public function index()
    {
        return view('BmsLists::lostreasons');
    }
    public function managelostReasons()
    {
       //$data = DB::table('enquiry_lost_reasons')->get();
       $data= EnquiryLostReason::select('id','reason','lost_reason_status')->get();
       if($data)
        {
            $result=['success' => true,'records' => $data];
            echo json_encode($result);
        }
        else
        {
            $result=['success' => false,'records' => 'Something Wents Wrong'];
            echo json_encode($result);
        }  
    }
    public function createLostReasons()
    {
       $postdata = file_get_contents("php://input");
       $request = json_decode($postdata, true);    
       $insertLostReason = EnquiryLostReason ::create($request['Data']);
       if($insertLostReason)
       {
           echo json_encode(['success' => true , 'records' => $insertLostReason->id]);
       }
       else
       {
           echo json_encode(['success' => false , 'records' =>'Something went wrong.']);
       }
          
    }
    public function updateLostReasons()
    {
       $postdata = file_get_contents("php://input");
       $request = json_decode($postdata, true);
      // echo"<pre>";print_r($request['Data']['reasonId']);exit;
       $updateLostReason = EnquiryLostReason ::where('id',$request['Data']['id'])->update($request['Data']);
       if($updateLostReason)
       {
           echo json_encode(['success' => true , 'records' => $request['Data']['id']]);
       }
       else
       {
           echo json_encode(['success' => false , 'records' =>'Something went wrong.']);
       }
    }
    
}
