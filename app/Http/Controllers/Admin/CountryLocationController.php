<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CountryLocation;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\Helper;
use App\Model\Countries;
use Config;
use DB;
use Toastr;

class CountryLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_country_location');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $countryLocationData = CountryLocation::with('country')->get();
        $pageData = ['title' => Config::get('constants.title.countrylocation'),'countryLocationData'=>$countryLocationData];
        return view('admin.country-location.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_country_location');
        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }

        $pageData = ["title" => Config::get('constants.title.countrylocation_add'),'countries' => $countries];
        return view('admin.country-location.create', $pageData);
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
        Helper::myLog('CountryLocation store : start');
        try {
            // return $request->country;

            $country=Countries::where('id',$request->country_id)->first();
            if($country->name){
                $checkAddress = CountryLocation::where('country_id',$request->country_id)->orWhere('address',$request->address)->count();
                 if ($checkAddress > 0) {
                    Helper::myLog('CountryLocation store : Location is exists');
                    return response()->json(['status' => 409, 'message' => 'The Location is already exists!']);
                } else{
                           $insertData = [
                                    'uuid' => Helper::getUuid(),
                                    'lat' => $request->lat,
                                    'log' => $request->log,
                                    'country_id' => $request->country_id,
                                    'state' => $request->state,
                                    'city' => $request->city,
                                    'address' => $request->address,
                                    // 'zipcode'=>$request->zipcode

                                ];
                                CountryLocation::create($insertData);
                                DB::commit();
                                Helper::myLog('CountryLocation store : finish');
                                Toastr::success(Config::get('constants.message.add'), 'Save');
                                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
                    }

            }else{
                  Helper::myLog('CountryLocation store : Location is does not exists in this Country');
                    return response()->json(['status' => 409, 'message' => 'Location is does not exists in this Country!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Country store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => ' Please Try Again']);
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
    public function edit($uuid)
    {


        $countries = Countries::pluck('name', 'id');
        $countryLocationData = CountryLocation::where('uuid', $uuid)->first();
        $pageData = ["title" => Config::get('constants.title.countrylocation_edit'), 'countryLocationData' => $countryLocationData,'countries' => $countries];
        return view('admin.country-location.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        DB::beginTransaction();
        Helper::myLog('CountryLocation update : start');
        try {

            $country=Countries::where('id',$request->country_id)->first();
            if($country->name == $request->country){
               $checkAddress = CountryLocation::where('address',$request->address)->orWhere('country_id',$request->country_id)->where('uuid','!=',$uuid)->count();
                 if ($checkAddress > 0) {
                    Helper::myLog('CountryLocation store : Location is exists');
                    return response()->json(['status' => 409, 'message' => 'The Location is already exists!']);
                } else{
                    $updateData = [
                        'lat' => $request->lat,
                        'log' => $request->log,
                        'country_id' => $request->country_id,
                        'state' => $request->state,
                        'city' => $request->city,
                        'address' => $request->address,
                        // 'zipcode'=>$request->zipcode
                    ];
                }
                    CountryLocation::where('uuid', $uuid)->update($updateData);
                    DB::commit();
                    Helper::myLog('CountryLocation update : finish');
                    Toastr::success(Config::get('constants.message.edit'), 'Update');
                    return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            }else{
                    Helper::myLog('CountryLocation store : Location is does not exists in this Country');
                    return response()->json(['status' => 409, 'message' => 'Location is does not exists in this Country!']);
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
    public function destroy($uuid)
    {
        DB::beginTransaction();
        Helper::myLog('CountryLocation delete : start');
        try {

            CountryLocation::where('uuid', $uuid)->delete();
            DB::commit();
            Helper::myLog('CountryLocation delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('CountryLocation delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {

            $ids = $request->ids;
            $status = CountryLocation::whereIn('id', explode(",", $ids))->delete();
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
