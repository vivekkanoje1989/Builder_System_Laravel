<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use DB;
use App\classes\Menuitems;
use App\Models\Title;
use App\Models\Gender;
use App\Models\BloodGroup;
use App\Models\Department;
use App\Models\EducationList;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class AdminController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    public function dashboard() {

        $rows = DB::select('CALL sp_test(1)');
//        return json_encode($id);
//        $id = Auth()->guard('admin')->user()->id;
        return view('layouts.backend.dashboard')->with('id', $rows[0]->name);
    }

    public function getMenuItems() {
        $permission = json_decode(Auth()->guard('admin')->user()->employee_submenus);
        $getMenu = Menuitems::getMenuItems();
        $menuItem = $accessToActions =array();
        foreach ($getMenu as $key => $menu) {
            $menu = (array) $menu;
            if(!empty($menu['url'])){
                $accessToActions[] = $menu['url'];
            }            
            $submenu_ids = explode(',', $menu['submenu_ids']);
            if ($menu['has_submenu'] == 1) {
                $intersection_arr = array_intersect($permission, $submenu_ids);
                if (empty($intersection_arr)){
                    continue;
                }
                if (isset($menu['submenu'])) {
                    foreach ($menu['submenu'] as $k => $submenu) {
                        $submenu = (array) $submenu;
                        if(!empty($submenu['url'])){
                            $accessToActions[] = $submenu['url'];
                        }
                        if (!(in_array($submenu['id'], $intersection_arr))) {
                            unset($menu['submenu'][$k]);
                        }
                    }
                }
            }
            $menuItem[] = $menu;
        }
        $collection = collect(['mainMenu'=>$menuItem]);
        $merged = $collection->merge(['actions'=>$accessToActions]);
        $mergedMmenu = $merged->all();
        return json_encode($mergedMmenu);
        exit;
    }
    
    public function getTitle(){
        $getTitle = Title::all();
        if(!empty($getTitle))
        {
            $result = ['success' => true, 'records' => $getTitle];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getGender(){
        $getGender = Gender::all();
        if(!empty($getGender))
        {
            $result = ['success' => true, 'records' => $getGender];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getBloodGroup(){
        $getBloodGroup = BloodGroup::all();
        if(!empty($getBloodGroup))
        {
            $result = ['success' => true, 'records' => $getBloodGroup];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getDepartments(){
        $getDepartments = Department::all();
        if(!empty($getDepartments))
        {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getEducationList(){
        $getEducationList = EducationList::all();
        if(!empty($getEducationList))
        {
            $result = ['success' => true, 'records' => $getEducationList];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getCountries(){
        $getCountires = Country::all();
        if(!empty($getCountires))
        {
            $result = ['success' => true, 'records' => $getCountires];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getStates(){
        $getStates = State::all();
        if(!empty($getStates))
        {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function getCities(){
        $getCities = City::all();
        if(!empty($getCities))
        {
            $result = ['success' => true, 'records' => $getCities];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
}
