<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TicketCategory;
use App\Model\Permissions;
use App\Model\PermissionRole;
use Config;
use DB;
use Toastr;
use App\Model\Helper;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_ticket_category');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $ticketCat = TicketCategory::get();
        $ticketCatdisplay = TicketCategory::where('parent_id',0)->get();
        $pageData = ['title' => Config::get('constants.title.ticket_cat'),'ticketCat'=>$ticketCat,'ticketCatdisplay'=>$ticketCatdisplay];
        return view('admin.ticket-category.index',$pageData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkPermission = Permissions::checkActionPermission('create_ticket_category');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }
        $ticketCat = TicketCategory::where('parent_id',0)->get();         
        $pageData = ['title' => Config::get('constants.title.ticket_cat_add'),'ticketCat'=>$ticketCat];
        return view('admin.ticket-category.create',$pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $name = $request->name;
            $parent_id=$request->parent_id;

            $checkCat = TicketCategory::where('name', $name)->count();
            if ($checkCat > 0) {
                Helper::myLog('TicketCategory store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The TicketCategory is already exists!']);
            } else {
                $insertData = [

                    'uuid' => Helper::getUuid(),
                    'name' => $name,
                    'parent_id' => $parent_id,
                ];
                TicketCategory::create($insertData);
                DB::commit();
                Helper::myLog('TicketCategory store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This TicketCategory has been Added!']);
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
        $ticketCate = TicketCategory::where('id', $id)->first();
        $categories = TicketCategory::where('parent_id',0)->pluck('name', 'id');
        $categories->prepend('Main', 0);
       
        $pageData = ["title" => Config::get('constants.title.ticket_cat_edit'), 'ticketCate' => $ticketCate,'categories'=> $categories];    
        return view('admin.ticket-category.edit', $pageData);
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
        Helper::myLog('TicketCategory update : start');
        try {

            $name = $request->name;
            $parent_id = $request->parent_id;
            $checkName = TicketCategory::where('name', $name)->where('id', '!=', $id)->count();
            if ($checkName > 0) {
                Helper::myLog('TicketCategory store : name is exists');
                return response()->json(['status' => 409, 'message' => 'The TicketCategory name is already exists!']);
            } else {
                $updateData = [
                    'name' => $name,
                    'parent_id' => $parent_id,
                ];
                TicketCategory::where('id', $id)->update($updateData);
                DB::commit();
                Helper::myLog('TicketCategory update : finish');
                Toastr::success(Config::get('constants.message.edit'), 'Update');
                return response()->json(['status' => 200, 'message' => 'This TicketCategory has been updated!']);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('TicketCategory update : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This TicketCategory has not been updated!']);
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
        Helper::myLog('TicketCategory Delete : start');
        try {

            $parent =TicketCategory::findOrFail($id);
            $array_of_ids = $this->getChildren($parent);
            array_push($array_of_ids, $id);
            TicketCategory::destroy($array_of_ids);

            // Category::where('id', $id)->delete();
            DB::commit();
            Helper::myLog('TicketCategory Delete : finish');
            // Toastr::success(Config::get('constants.message.delete'), 'Delete');
            return \Response::json(['status' => Config::get('constants.status.success'), 'msg' => Config::get('constants.message.delete')], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('State delete : exception');
            Helper::myLog($exception);
            return \Response::json(['status' => Config::get('constants.status.fail'), 'msg' => Config::get('constants.message.oops'), "errorInfo" => $ex->getMessage()], 200);

        }
    }
    private function getChildren($category){
        $ids = [];
        foreach ($category->children as $cat) {
            $ids[] = $cat->id;
            $ids = array_merge($ids, $this->getChildren($cat));
        }
        return $ids;
    }
    public function changeStatus(Request $request){
        try {

            $ticketCategory = TicketCategory::find($request->id);

            $ticketCategory->status = $request->status;
            $status=$ticketCategory->save();            
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
