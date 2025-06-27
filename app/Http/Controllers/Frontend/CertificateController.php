<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\Helper;
use App\Model\ChefCertificate;
use Toastr;
use Datatables;
Use \Carbon\Carbon;
use Validator;
use Redirect;
use Session;
use Config;
use Auth;
use File;
use DB;


class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $certiData=ChefCertificate::where('chef_id',auth('chef')->user()->id)->get();
        $pageData = [
                        'certiData'=>$certiData,
                      ];
        return view('frontend.chef-dashboard.certificate.index',$pageData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('frontend.chef-dashboard.certificate.create');
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
        Helper::myLog('Chef Certification Store : start');
        try {            

            $insertData = [ 
                'chef_id'=>auth('chef')->user()->id,
                'uuid' => Helper::getUuid(),
                'certi_name'=> $request->certi_name,                  
                'certi_authority' => $request->certi_authority,
                'certi_from' => $request->certi_from,
                'certi_to' => $request->certi_to,
                'certi_url' => $request->certi_url,
                'status' =>'1',
                
            ];
            if ($file = $request->file('image')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(base_path() . '/public/frontend/images/certificate/', $fileName);
                $image = $fileName;
                $insertData['image']=$image;
            }
            $itemData=ChefCertificate::create($insertData);    
            
            DB::commit();            
            Helper::myLog('Chef Certification store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Certification store : exception');
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
    public function edit($uuid)
    {
        $certiData = ChefCertificate::where('uuid', $uuid)->first();
                    
        $pageData = ['certiData'=> $certiData];
        return view('frontend.chef-dashboard.certificate.edit',$pageData);
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
        Helper::myLog('Chef Certification update : start');
        try {
            $updateData = [ 
                'certi_name'=> $request->certi_name,                  
                'certi_authority' => $request->certi_authority,
                'certi_from' => $request->certi_from,
                'certi_to' => $request->certi_to,
                'certi_url' => $request->certi_url
            ]; 
           
            if ($file = $request->file('image')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;

                $file->move(base_path() . '/public/frontend/images/certificate/', $fileName);
                if ($request->oldImage) {
                    $destinationPath = base_path() . '/public/frontend/images/certificate/' . $request->oldImage;
                    File::delete($destinationPath); 
                }
                $updateData['image']=$fileName;
            }
            
            ChefCertificate::where('id', $id)->update($updateData);            
            DB::commit();
            Helper::myLog('Chef Certification update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Certification update : exception');
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
        Helper::myLog('Chef Certification delete : start');
        try {

            ChefCertificate::where('id', $id)->delete();
           
            DB::commit();
            Helper::myLog('Chef Certification delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Chef Certification : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    public function changeStatus(Request $request){
        try {
            
            $certi = ChefCertificate::find($request->id);
            $certi->status = $request->status==1?'A':'I';
            $status=$certi->save();            
            if ($status) {
                return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.message_status_alert')]);
            } else {
                return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops')]);
            }
        } catch (\Illuminate\Database\QueryException $exc) {
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => $exc->getMessage()]);
        }
    }
}
