<?php namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\ProjectTypes;


class ManageProjectTypesController extends Controller {
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view("BmsLists::projecttypes");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function manageProjectTypes()
	{
		//$getTypes = ProjectTypes::join('project_types', 'project_types.project_type_id', '=', 'lst_block_types.project_type_id')
            //->select('lst_payment_headings.id', 'lst_payment_headings.type_of_payment', 'lst_payment_headings.is_tax_heading', 'lst_payment_headings.is_date_dependent', 'project_types.project_type_id as project_id','project_types.project_type_name as project_name')
            //->get();
            $getTypes = ProjectTypes::all();

        if(!empty($getTypes))
        {
            $result = ['success' => true, 'records' => $getTypes];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
	}
	 public function createProjectTypes() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = ProjectTypes::where(['project_type_name' => $request['project_type_name']])->get()->count();
        if ($cnt > 0) {  //exists project types
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {
            $state = ProjectTypes::create($request);
            $result = ['success' => true, 'result' => $state];
            return json_encode($result);
        }
    }

    public function updateProjectTypes() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = ProjectTypes::where(['project_type_name' => $request['project_type_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {
            $result = ProjectTypes::where('project_type_id', $request['project_type_id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }
	
}
