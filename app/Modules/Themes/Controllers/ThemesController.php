<?php

namespace App\Modules\Themes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Themes\Models\WebThemes;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use Illuminate\Support\Facades\Input;
use App\Classes\S3;
use Auth;

class ThemesController extends Controller {

    public function index() {
        return view("Themes::index");
    }

    public function getThemes() {
        $theme = WebThemes::all();
        if (!empty($theme)) {
            return json_encode(['records' => $theme, 'status' => true]);
        } else {
            return json_encode(['errorMsg' => 'No record', 'status' => false]);
        }
    }

    public function store() {
        $input = Input::all();

        $cnt = WebThemes::where(['theme_name' => $input['theme_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Theme name already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['imageUrl'])) {
                $originalName = $input['imageUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {
                    $s3FolderName = "Themes";
                    $imageName = 'theme_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['imageUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['imageUrl']->getPathName(), $imageName, $s3FolderName);
                    $image_url = $imageName;
                    unset($input['imageUrl']);
                } else {
                    unset($input['imageUrl']);
                    $image_url = '';
                }
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $cre = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create['Themes'] = array_merge($input, $cre);
            $create['Themes']['image_url'] = $image_url;
            $result = WebThemes::create($create['Themes']);
            $last3 = WebThemes::latest('id')->first();
            if (!empty($result)) {
                return json_encode(['records' => $result, 'lastinsertid' => $last3->id, 'image' => $image_url, 'success' => true]);
            } else {
                return json_encode(['errorMsg' => 'Failed to create', 'success' => false]);
            }
        }
    }

    public function update($id) {
        $input = Input::all();

        $cnt = WebThemes::where(['theme_name' => $input['theme_name']])->where('id', '!=', $id)->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Theme name already exists'];
            return json_encode($result);
        } else {
            if (!empty($input['imageUrl'])) {
                $originalName = $input['imageUrl']->getClientOriginalName();
                if ($originalName !== 'fileNotSelected') {

                    $s3FolderName = "Themes";
                    $imageName = 'theme_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['imageUrl']->getClientOriginalExtension();
                    S3::s3FileUpload($input['imageUrl']->getPathName(), $imageName, $s3FolderName);
                    $image_url = $imageName;
                    unset($input['imageUrl']);
                } else {
                    unset($input['imageUrl']);
                    $image_url = '';
                }
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $cre = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create['Themes'] = array_merge($input, $cre);
            if (!empty($image_url)) {
                $create['Themes']['image_url'] = $image_url;
            } else {
                $create['Themes']['image_url'] = $input['image'];
            }
            unset($create['Themes']['image']);
            $result = WebThemes::where('id', '=', $id)->update($create['Themes']);

            return json_encode(['records' => $result, 'image' => $create['Themes']['image_url'], 'success' => true]);
        }
    }

}
