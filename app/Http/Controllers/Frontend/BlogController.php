<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ChefProfileBlog;
use App\Model\Helper;
use Toastr;
use Config;
use Auth;
use DB;
use File;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogData = ChefProfileBlog::where('chef_id',auth('chef')->user()->id)->get();
        $pageData = [
                        'blogData'=>$blogData,
                      ];
        return view('frontend.chef-dashboard.blog.index',$pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.chef-dashboard.blog.create');
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
        Helper::myLog('Blog Store : start');
        try {            
               if ($file = $request->file('image')) {
                $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/blog/', $fileName);
                    $blogimage = $fileName;
                }
               
            $insertData = [ 
                'chef_id'=>auth('chef')->user()->id,
                'uuid' => Helper::getUuid(),
                'title'=> $request->title, 
                'image'=> $blogimage,              
                'description' => $request->description,
                'status' =>'1',
            ];
            
            $itemData=ChefProfileBlog::create($insertData);    
            DB::commit();            
            Helper::myLog('Blog store : finish');
            Toastr::success(Config::get('constants.message.add'), 'Save');
            return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Blog store : exception');
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
        $blogData = ChefProfileBlog::where('uuid', $uuid)->first();                  
        $pageData = ['blogData' => $blogData];
        return view('frontend.chef-dashboard.blog.edit',$pageData);
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
        Helper::myLog('Blog update : start');
        try {

            $updateData = [ 
                'title'=> $request->title,                  
                'description' => $request->description
            ];
            if ($file = $request->file('image')) {
                  
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(base_path() . '/public/frontend/images/blog/', $fileName);
                   
                    if ($request->oldImage) {
                       $destinationPath = base_path() . '/public/frontend/images/blog/' . $request->oldImage;
                        File::delete($destinationPath); // remove oldfile
                        $updateData['image']=$fileName;
                    }
                }        
            
            ChefProfileBlog::where('id', $id)->update($updateData);
            DB::commit();
            Helper::myLog('Blog update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
           
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Blog update : exception');
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
        Helper::myLog('Blog delete : start');
        try {

            ChefProfileBlog::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('Blog delete : finish');
            Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Blog delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
}
