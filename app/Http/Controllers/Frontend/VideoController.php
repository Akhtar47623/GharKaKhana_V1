<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use App\Model\ChefProfileVideo;
use App\Model\Helper;
use App\Model\ChefGelleryImage;
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


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $videoData = ChefProfileVideo::where('chef_id',auth('chef')->user()->id)->get();
          $pageData = [
                        'videoData'=>$videoData,
                      ];
        return view('frontend.chef-dashboard.video.index',$pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('frontend.chef-dashboard.video.create');
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
        Helper::myLog('Video Store : start');
        try {            
               
            $insertData = [ 
                'chef_id'=>auth('chef')->user()->id,
                'uuid' => Helper::getUuid(),
                'title'=> $request->title,                  
                'description' => $request->description,
                'video_link' => $request->video_link,
                'status' =>'1',
            ];
            
            $itemData=ChefProfileVideo::create($insertData);    
            DB::commit();            
            Helper::myLog('Video store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Video store : exception');
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
        $videoData = ChefProfileVideo::where('uuid', $uuid)->first();                  
        $pageData = ['videoData' => $videoData];
        return view('frontend.chef-dashboard.video.edit',$pageData);
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
        Helper::myLog('Video update : start');
        try {

            $updateData = [ 
                'title'=> $request->title,                  
                'description' => $request->description,
                'video_link' => $request->video_link,
            ];
            
            ChefProfileVideo::where('id', $id)->update($updateData);
            DB::commit();
            Helper::myLog('Video update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Video update : exception');
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
        Helper::myLog('Video delete : start');
        try {

            ChefProfileVideo::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Video delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Video delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }

    
}
