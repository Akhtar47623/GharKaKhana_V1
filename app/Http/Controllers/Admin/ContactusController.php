<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\ContactUs;
use App\Model\Helper;
use DB;
use Config;
use Redirect;
use Session;
use File;
use Log;
use Toastr;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_contactus');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $contactData = ContactUs::orderby('id','desc')->get();
        $pageData = ['title' => Config::get('constants.title.contactus'),'contactData'=>$contactData];
        return view('admin.contact-us.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        Helper::myLog('Contact us delete : start');
        try {

            ContactUs::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Contact us delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Contact us delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $exception->getMessage()], 200);

        }
    }
    public function multiDelete(Request $request) {
        try {
            $ids = $request->ids;
            $status = ContactUs::whereIn('id', explode(",", $ids))->delete();
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
