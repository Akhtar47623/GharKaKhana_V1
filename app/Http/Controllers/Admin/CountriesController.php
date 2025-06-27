<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Countries;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Helper;
use App\Model\CountryCategories;
use App\Model\Categories;
use DB;
use Config;
use Datatables;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_countries');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $countryData = Countries::get();
        $pageData = ['title' => Config::get('constants.title.country'),'countryData'=>$countryData];
        return view('admin.country.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_countries');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }

        $pageData = ["title" => Config::get('constants.title.country_add')];
        return view('admin.country.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        Helper::myLog('Country store : start');
        try {

            $sortname = $request->sortname;
            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $phoneCode = $request->phoneCode;

            $checkName = Countries::where('name', $name)->count();
            $checkSortname = Countries::where('sortname', $sortname)->count();
            
            if ($checkName > 0) {
                Helper::myLog('Country store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The country name is already exists!']);
            } else if ($checkSortname) {
                Helper::myLog('Country store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The country sort name is already exists!']);
            } else {
                $insertData = [
                    'sortname' => $sortname,
                    'name' => $name,
                    'slug' => $slug,
                    'phone_code' => $phoneCode,
                ];
                Countries::create($insertData);
                DB::commit();
                Helper::myLog('Country store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Country store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countryData = Countries::where('id', $id)->first();
        $pageData = ["title" => Config::get('constants.title.country_edit'), 'countryData' => $countryData];
        return view('admin.country.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        Helper::myLog('Country update : start');
        try {

            $sortname = $request->sortname;
            $name = $request->name;
            $slug = Helper::slugify($request->name);
            $phoneCode = $request->phoneCode;

            $checkName = Countries::where('name', $name)->where('id', '!=', $id)->count();
            $checkSortname = Countries::where('sortname', $sortname)->where('id', '!=', $id)->count();
            if ($checkName > 0) {
                Helper::myLog('Country store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The country name is already exists!']);
            } else if ($checkSortname) {
                Helper::myLog('Country store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The country sort name is already exists!']);
            } else {
                $updateData = [
                    'sortname' => $sortname,
                    'name' => $name,
                    'slug' => $slug,
                    'phone_code' => $phoneCode,
                ];
                Countries::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Country update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Country update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        Helper::myLog('Country delete : start');
        try {

            Countries::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Country delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Country delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Countries::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
    public function countryCategory($id){

        $countryCategories=CountryCategories::where('country_id',$id)->get();
        $categoryList = Categories::get();
        $countryId=$id;
        $pageData = [
            "title" => Config::get('constants.title.country_category'),
            'countryCategories' => $countryCategories,
            'categoryList' => $categoryList,
            'countryId' => $countryId
        ];        
        return view('admin.country.country-category',$pageData);
    }
    
    public function countryCategoryStore(Request $request){
        Helper::myLog('Country category store : start');
        DB::beginTransaction();
        try {
            $services =$request->services;
            foreach ($services as $key => $value) {
                $insertData = [
                    'country_id' => $request->country_id,
                    'category_id' => $value,
                ];                
                CountryCategories::create($insertData);
            }            
            Helper::myLog('Country category store : finish');
            DB::commit();
            Toastr::success(Config::get('constants.message.edit'), 'Edit');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback(); // Rollback Transaction
            Log::error("QueryException While Create new country category, " . $e->getMessage());
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }

    public function countryCategoryUpdate(Request $request){
        
        Helper::myLog('Country category store : start');
        DB::beginTransaction();
        try {
            $cntry_id = $request->country_id;
            CountryCategories::where('country_id', $cntry_id)->delete();
            $services =$request->services;
            foreach ($services as $key => $value) {
                $insertData = [
                    'country_id' => $request->country_id,
                    'category_id' => $value,
                ];                
                CountryCategories::create($insertData);
            }            
             Helper::myLog('Country category store : finish');
             DB::commit();
             Toastr::success(Config::get('constants.message.edit'), 'Edit');
             return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback(); // Rollback Transaction
            Log::error("QueryException While Create new country category, " . $e->getMessage());
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been updated!']);
        }
    }
   
}
