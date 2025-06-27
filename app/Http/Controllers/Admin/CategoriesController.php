<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Categories;
use App\Model\Countries;
use App\Model\States;
use App\Model\Helper;
use DB;
use Config;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_category');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $selectedItems = ['categories.*', 'countries.name as country_id','states.name as state_id'];
        $categoryData = Categories::select($selectedItems)
                        ->leftjoin('countries', 'categories.country_id', 'countries.id')
                        ->leftjoin('states', 'categories.state_id', 'states.id');
        if(auth('admin')->user()->role_id==1 || auth('admin')->user()->role_id==2){
            $categoryData=$categoryData->orderBy('id','desc')->get();
        }else{
            $categoryData=$categoryData->where('user_id',auth('admin')->user()->id)->orderBy('id','desc')->get();
        }
        $pageData = ['title' => Config::get('constants.title.categories'),'categoryData'=>$categoryData];
        return view('admin.category.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.category_add'),'countries'=>$countries];
        return view('admin.category.create', $pageData);
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
        Helper::myLog('Category store : start');
        try {
            $name = $request->name;
            $country_id = $request->country_id;
            $state_id = $request->state_id;
            $description = $request->description;
            $user_type = implode(',',$request->user_type);

            $checkName = Categories::where('name', $name)
                        ->where('country_id',$country_id)
                        ->where('state_id',$state_id)->count();
             $checkName1 = Categories::where('name', $name)
                        ->where('country_id',$country_id)
                        ->where('state_id',0)->count();
            if ($checkName > 0 || $checkName1 > 0) {
                Helper::myLog('Category store : Name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {
                if ($file = $request->file('image')) {
                $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/backend/images/category/', $fileName);
                    $image = $fileName;
                }
                $insertData = [
                    'uuid' => Helper::getUuid(),
                    'user_id'=>auth('admin')->user()->id,
                    'name' => $name,
                    'description'=>$description,
                    'image' => $image,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'user_type' => $user_type
                ];

                Categories::create($insertData);
                DB::commit();
                Helper::myLog('Category store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Category store : exception');
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
        $categoryData = Categories::where('id', $id)->first();
        $countries = Countries::pluck('name', 'id');
        $states = States::where('country_id',$categoryData->country_id)->pluck('name','id');
        $states[0]="All";

        $selUserType = explode(",", $categoryData->user_type);
        $pageData = [
            "title" => Config::get('constants.title.category_edit'),
            'categoryData' => $categoryData,
            'countries' => $countries,
            'states' => $states,
            'selUserType' => $selUserType
            ];
        return view('admin.category.edit', $pageData);
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
        Helper::myLog('Category update : start');
        try {

            $name = $request->name;
            $country_id = $request->country_id;
            $state_id = $request->state_id;
            $user_type = implode(',',$request->user_type);
            $description = $request->description;
            $checkName = Categories::where('name', $name)
                        ->where('country_id',$country_id)
                        ->where('state_id',$state_id)
                        ->where('id', '!=', $id)->count();
            $checkName1 = Categories::where('name', $name)
                        ->where('country_id',$country_id)
                        ->where('state_id',0)
                        ->where('id', '!=', $id)->count();
            if ($checkName > 0 || $checkName > 0) {
                Helper::myLog('Category update : name is exists');
                return response()->json(['status' => 409, 'message' => 'Name is already exists!']);
            } else {
                $updateData = [
                    'name' => $name,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'user_type' => $user_type,
                    'description' => $description
                ];
                if ($file = $request->file('image')) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/backend/images/category/', $fileName);
                    $updateData['image'] = $fileName;
                    if ($request->oldImage != 'default.png') {
                         $destinationPath = base_path() . '/public/backend/images/category/' . $request->oldImage;
                        File::delete($destinationPath); // remove oldfile
                     }
                }
                Categories::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('Category update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Category update : exception');
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
        Helper::myLog('Category delete : start');
        try {

            Categories::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Category delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Category delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = Categories::whereIn('id', explode(",", $ids))->delete();
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_success_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }

}
