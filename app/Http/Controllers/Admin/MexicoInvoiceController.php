<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Helper;
use App\Model\Permissions;
use App\Model\PermissionRole;
use App\Model\MexicoInvoice;
use App\Model\Countries;
use App\Model\Order;
use App\Model\Taxes;
use Yajra\DataTables\Facades\DataTables;
use Toastr;
use Config;
use DB;
use File;
class MexicoInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkPermission = Permissions::checkActionPermission('view_invoice');
        $pageData = ["title" => Config::get('constants.title.access_denied')];
        if ($checkPermission == false) {
            return view('admin.access-denied',$pageData);
        }      
                     
        $pageData = ['title' => Config::get('constants.title.invoice')];
        return view('admin.invoice.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $invoiceData = MexicoInvoice::where('id', $id)->first();
        
        $pageData = [
                    "title" => Config::get('constants.title.invoice_edit'), 
                    'invoiceData' => $invoiceData
                    ];
        return view('admin.invoice.edit', $pageData);
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
        Helper::myLog('Invoice update : start');
        try {

            $status = $request->status;
            $updateData = [
                'status' => $status
            ];


            if ($file = $request->file('invoice')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(base_path() . '/public/backend/images/invoice/', $fileName);
                $updateData['invoice'] = $fileName;
                if ($request->oldImage != '') {
                    $destinationPath = base_path() . '/public/backend/images/invoice/' . $request->oldImage;
                    File::delete($destinationPath); // remove oldfile
                }
            }

            MexicoInvoice::where('id', $id)->update($updateData);
            $invData = MexicoInvoice::where('id', $id)->first();
            if($invData->status==3 && !empty($invData->invoice)){
                $file = './public/backend/images/invoice/' . $invData->invoice;
                $emailData['display_name'] = $invData->name;
                $email = 'sutaria.vishal@gmail.com';
                Helper::sendMailInvoice($emailData, 'admin.invoice.mail', 'Invoice', $email, $file);
            }
            DB::commit();
            Helper::myLog('Invoice update : finish');
            Toastr::success(Config::get('constants.message.edit'), 'Update');
            return response()->json(['status' => 200, 'message' => 'This information has been updated!']);
            
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Invoice update : exception');
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
        //
    }

    public function getData()
    {
        try {
            
            $selectedItems = ['mexico_invoices.*'];
            $data = MexicoInvoice::select($selectedItems)
            ->leftjoin('order', 'mexico_invoices.order_id', 'order.id')->orderby('id','desc')
            ->where('order.status',7)->get();
            
            return Datatables::of($data)
            
            ->addColumn('order_id', function($r) {
                return '<a href="'.route('mexico-invoice-detail', $r->order_id).'">#'.$r->order_id.'</a>';
            })
             ->addColumn('itechcheck', function($r) {
                //return '<input type="checkbox" class="sub_chk" data-id="' . $r->id . '">';
                return '<div class="form-check pull-left">
                            <label class="form-check-label">
                              <input type="checkbox" id="master" class="sub_chk" data-id="' . $r->id . '">
                              <span class="form-check-sign"></span>
                            </label>
                        </div>';
            })
            ->addColumn('status', function($r) {
                //return '<input type="checkbox" class="sub_chk" data-id="' . $r->id . '">';
                
                if($r->status==1){
                    return '<span class="label label-warning">Pending</span>';
                }
                if($r->status==2){
                    return '<span class="label label-info">Processing</span>';
                }
                if($r->status==3){
                    return '<span class="label label-danger">Ready</span>';
                }
                
            })
            ->addColumn('action', function($r) {
                $editButton = '';
                $deleteButton = '';
                $viewInvoice = '';
                if($r->invoice!=NULL){
                    $viewInvoice = '<a href="'.asset('public/backend/images/invoice/'.$r->invoice).'" id="invoice" title="Edit" rel="tooltip" class="btn btn-round btn-info" download><i class="fa fa-file-o" aria-hidden="true"></i></a>';
                }
                $checkPermission = Permissions::checkActionPermission('update_invoice');
                if ($checkPermission == true) {
                    $editButton='<a href="'.route('mexico-invoice.edit', $r->id).'" id="edit" title="Edit" rel="tooltip" class="btn btn-round btn-warning edit"><i class="fa fa-pencil"></i></a>';
                }
                $checkPermission = Permissions::checkActionPermission('delete_invoice');
                if ($checkPermission == true) {
                    $deleteButton='<button id="invoice" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="'.$r->id.'"  data-action="' . route('mexico-invoice.destroy', $r->id) . '" data-message="'.Config::get('constants.message.confirm').'"><i class="fa fa-trash"></i></button>';
                }
                return $viewInvoice . ' ' .$editButton . ' ' . $deleteButton ;
            })
            
            ->rawColumns(['action', 'itechcheck','status','order_id'])
            ->toJson();
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['data' => 0, 'message' => $ex->getMessage()], 500);
        }
    }
    public function invoiceDetail($id)
    {
        $invoiceData=MexicoInvoice::where('order_id',$id)->first();
        $orderData = Order::with('orderItems','chef')->where('id',$id)->first();

         $taxes = Taxes::select('tax')
         ->where('state_id',$orderData->chef->chefLocation->state_id)
         ->where('city_id',$orderData->chef->chefLocation->city_id)->first();   
         
        $currency = Countries::where('id',$orderData->chef->country_id)->first();
        $pageData = [
            'title' => Config::get('constants.title.order_detail'),
            'invoiceData'=>$invoiceData,
            'orderData' => $orderData, 
            'currency'=>$currency,
            'taxes'=>$taxes
        ];        
        return view('admin.invoice.invoice-detail',$pageData);        
    }
}
