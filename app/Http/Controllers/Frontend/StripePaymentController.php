<?php
   
namespace App\Http\Controllers\Frontend; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Model\Helper;
use App\Model\Users;
use App\Model\Order;
use App\Model\OrderItems;
use App\Model\OrderItemOptions;
use App\Model\CustLocation;
use App\Model\Location;
use App\Model\OrderLocation;
use App\Model\CreditPayment;
use App\Model\CashPayment;
use App\Model\ChefDiscount;
use App\Model\VendorDiscount;
use App\Model\Discount;
use App\Model\UsedCoupons;
use App\Model\MexicoInvoice;
use App\Model\Tax;
use Session;
use Stripe;
use Toastr;
use Datatables;
use Socialite;
Use \Carbon\Carbon;
use Validator;
use Redirect;
use Config;
use Auth;
use File;
use DB;

   
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        
        if(session()->has('order')){
                $order = session()->get('order');
                $orderData=$order['orderData'];
                $chefId = $orderData['chef_id'];
        }
        if(Helper::getLocCountry($chefId)=='142'){
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $intent = \Stripe\PaymentIntent::create([
                  'payment_method_types' => ['card'],
                  
                  'amount' => 10000,
                  'currency' => 'mxn',
                  'transfer_data' => [
                    'amount' => 7000,
                    'destination' => 'acct_1JUqFBRIXCwnoqaX',
                  ],
                ]);
               
                $dispPayChkbx=1;
                $pageData = ['dispPayChkbx'=>$dispPayChkbx,'client_secret' => $intent->client_secret];
                return view('frontend.payment.payment-stripe',$pageData);
        }else{
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $intent = \Stripe\PaymentIntent::create([
                  'payment_method_types' => ['card'],
                  
                  'amount' => 10000,
                  'currency' => 'mxn',
                  'transfer_data' => [
                    'amount' => 7000,
                    'destination' => 'acct_1JUqFBRIXCwnoqaX',
                  ],
                ]);
                $dispPayChkbx=0;
                $pageData = ['dispPayChkbx'=>$dispPayChkbx,'client_secret' => $intent->client_secret];
                return view('frontend.payment.payment-stripe',$pageData);
        }
       
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

        // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $payment_intent = \Stripe\PaymentIntent::create([
        //   'payment_method_types' => ['card'],
          
        //   'amount' => 10000,
        //   'currency' => 'mxn',
        //   'transfer_data' => [
        //     'amount' => 7000,
        //     'destination' => 'acct_1JUqFBRIXCwnoqaX',
        //   ],
        // ]);
        // DB::beginTransaction();
        // Helper::myLog('Credit Card Payment Store : start');
        // try {
        //     if(session()->has('order')){
        //     	$order = session()->get('order');
        //         $orderData=$order['orderData'];
                
        //         $chefId = $orderData['chef_id'];
        //         $custId = $orderData['cust_id']; 
        //         $deliveryDate = $orderData['delivery_date']; 
        //         $pickDelOption = $orderData['pick_del_option']; 
        //         $pickDelTime = $orderData['pick_del_time']; 
        //         $deliveryBy = $orderData['delivery_by'];
        //         $currencyCode = $orderData['currency_code'];
        //         $chefCommissionPer = $orderData['chef_commission_per'];
        //         $deliveryCommissionPer = $orderData['delivery_commission_per']; 
                
        //         $subTotal = $orderData['sub_total'];
        //         $chefDiscount = $orderData['chef_discount'];
        //         $houseDiscount = $orderData['house_discount'];
        //         $makemDiscount = $orderData['makem_discount']; 
        //         $serviceFee = $orderData['service_fee']; 
        //         $deliveryFee = $orderData['delivery_fee']; 
        //         $taxFee = $orderData['tax_fee'];
        //         $tipFee = $orderData['tip_fee'];
        //         if(Helper::getLocCountry($chefId)=='142'){
        //             $total = $subTotal-$chefDiscount-$houseDiscount-$makemDiscount+$deliveryFee;
        //             $grandTotal = $total+$tipFee;

        //             $cPer = $grandTotal-($grandTotal*$chefCommissionPer/100); 

        //             $cTax = (($subTotal*$taxPer)/($taxPer+100))+(($deliveryFee*$taxPer)/($taxPer+100))+(($tipFee*$taxPer)/($taxPer+100));               
        //             $chefCommission = $cPer-($cTax/2);
                        
                                        
        //             $delCommission = 0;
        //             $revFromChef =$grandTotal-$cPer-($cTax/2);

        //             $revFromDel = 0;
        //             $taxFee=0;
        //             $serviceFee=0;
        //         }else{

        //             $total = $subTotal-$chefDiscount-$houseDiscount-$makemDiscount+$serviceFee+$deliveryFee+$taxFee;
        //             $grandTotal = $total + $tipFee;
        //             $cPer = $subTotal*$chefCommissionPer/100;  
        //             $chefCommission = $subTotal-$chefDiscount-$cPer;                    
        //             $dPer = $deliveryFee*($deliveryCommissionPer/100);                    
        //             $delCommission = ($deliveryFee!=0)?$deliveryFee-$dPer:0;
        //             $revFromChef = $cPer+$serviceFee-$houseDiscount-$makemDiscount;
        //             $revFromDel = ($deliveryFee!=0)?$dPer:0;
        //         }
                               
        //         $d=date("m/d/Y",strtotime($deliveryDate));
        //         $createOrderData = [                    
        //             'uuid' => Helper::getUuid(),
        //             'chef_id' => $chefId,
        //             'cust_id' => $custId,
        //             'pick_del_option' => $pickDelOption,
        //             'delivery_by' => $deliveryBy,
        //             'payment_method' =>2,
        //             'delivery_date' => date("Y-m-d",strtotime($deliveryDate)),
        //             'delivery_time' => $pickDelTime,
        //             'sub_total' => $subTotal,
        //             'chef_discount' => $chefDiscount,
        //             'house_discount' => $houseDiscount,
        //             'makem_discount' => $makemDiscount,
        //             'service_fee' => $serviceFee,
        //             'delivery_fee' => $deliveryFee,
        //             'tax_fee' => $taxFee,
        //             'total' => $total,
        //             'tip_fee' => $tipFee,
        //             'pay_total' => $grandTotal,
        //             'chef_commission_fee' => $chefCommission,
        //             'delivery_commission_fee' => $delCommission,
        //             'revenue_from_chef' => $revFromChef, 
        //             'revenue_from_delivery' => $revFromDel,
        //             'created_at_timezone' =>   $request->timezone                   
        //         ];
                
        //         $orderRec=Order::create($createOrderData);
                              
        //         foreach ($order as $v) {
        //             $optionTotal=0;  
        //             if(!empty($v['menu_id'])){
        //                 if($v['option']!=NULL){                            
        //                     foreach($v['option'] as $option){                                
        //                         $optionTotal += $option['rate'];                     
        //                     }
        //                 }
        //                 $tot = $v['quantity'] * ($v['price'] + $optionTotal);                    
        //                 $orderItemData=[
        //                     'order_id'=>$orderRec->id,
        //                     'menu_id'=>$v['menu_id'],
        //                     'qty'=>$v['quantity'],
        //                     'rate'=>$v['price'],
        //                     'option_rate'=>$optionTotal,
        //                     'total' => $tot,
        //                     'notes'=>$v['instruction']
        //                 ];                        
        //                 $orderItemRec=OrderItems::create($orderItemData);
        //                 if($v['option']!=NULL){
        //                     foreach($v['option'] as $option){
        //                         $orderItemOptionData=[
        //                             'order_item_id'=>$orderItemRec->id,
        //                             'option'=>$option['option'],
        //                             'rate'=>$option['rate']
        //                         ];
        //                         $orderItemOptionId=OrderItemOptions::create($orderItemOptionData);    
        //                     }
        //                 }
        //             }                
        //         }
        //         $orderLocationData=[
        //             'order_id'=>$orderRec->id,
        //         ];
        //         if($pickDelOption==1){
        //             $orderLocationData['pickup_address']=Location::chefAddress($chefId);
        //         }else{
        //             if($deliveryBy==1)
        //                 $orderLocationData['customer_address']=CustLocation::customerAddress($custId);
        //             else
        //                 $orderLocationData['pickup_address']=Location::chefAddress($chefId);
        //                 $orderLocationData['customer_address']=CustLocation::customerAddress($custId);
        //         }                
        //         OrderLocation::create($orderLocationData);
            
        //         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        //         $stripe=Stripe\Charge::create ([
        //                 "amount" => 100 * round($grandTotal, 2),
        //                 "currency" => $currencyCode,
        //                 "source" => $request->stripeToken,
        //                 "description" => "Making test payment." 
        //         ]);
                
        //         if($stripe['status'] == 'succeeded') {
        //             $paymentData=[
        //                 'order_id'=>$orderRec->id,
        //                 'payment_transaction_id'=>$stripe['id'],
        //                 'payment_status'=>$stripe['status']
                        
        //             ];
        //             CreditPayment::create($paymentData);

        //             $updateOrderData=[
        //                 'status'=>Order::SUCCESS
        //             ];
        //             Order::where('id', $orderRec->id)->update($updateOrderData);
        //             Session::forget('cart.' . $d);
        //             Session::forget('order');
        //             Session::flash('success', 'Payment successful!');
        //             DB::commit();            
        //             Helper::myLog('Credit Card Payment store : finish');
        //             return redirect('/payment-success');                
        //         } 
        //     }
           
        // } catch (\Exception $exception) {
        //     DB::rollBack();
        //     Helper::myLog('Credit Card Payment : exception');
        //     Helper::myLog($exception);
        //     Session::flash('error', 'Payment is not successful. Try again..');
        // }
    }


    public function cashOnDelivery(Request $request)
    {
        
        DB::beginTransaction();
        Helper::myLog('Cash Payment Store : start');
        try {
            if(session()->has('order')){
                $order = session()->get('order');
                $orderData=$order['orderData'];

                $chefId = $orderData['chef_id'];
                $custId = $orderData['cust_id']; 
                $deliveryDate = $orderData['delivery_date']; 
                $pickDelOption = $orderData['pick_del_option']; 
                $pickDelTime = $orderData['pick_del_time']; 
                $deliveryBy = $orderData['delivery_by'];
                
                $chefCommissionPer = $orderData['chef_commission_per'];
                $deliveryCommissionPer = $orderData['delivery_commission_per']; 
                
                $subTotal = $orderData['sub_total'];
                $chefDiscount = $orderData['chef_discount'];
                $houseDiscount = $orderData['house_discount'];
                $makemDiscount = $orderData['makem_discount']; 
                $serviceFee = $orderData['service_fee']; 
                $deliveryFee = $orderData['delivery_fee']; 
                $taxFee = $orderData['tax_fee'];
                $taxPer = $orderData['tax_per'];
                $tipFee = $orderData['tip_fee'];


                if(Helper::getLocCountry($chefId)=='142'){
                    $total = $subTotal-$chefDiscount-$houseDiscount-$makemDiscount+$deliveryFee;
                    $grandTotal = $total+$tipFee;

                    $cPer = $grandTotal-($grandTotal*$chefCommissionPer/100); 

                    $cTax = (($subTotal*$taxPer)/($taxPer+100))+(($deliveryFee*$taxPer)/($taxPer+100))+(($tipFee*$taxPer)/($taxPer+100));               
                    $chefCommission = $cPer-($cTax/2);
                        
                                        
                    $delCommission = 0;
                    $revFromChef =$grandTotal-$cPer-($cTax/2);

                    $revFromDel = 0;
                    $taxFee=0;
                    $serviceFee=0;
                }else{

                    $total = $subTotal-$chefDiscount-$houseDiscount-$makemDiscount+$serviceFee+$deliveryFee+$taxFee;
                    $grandTotal = $total + $tipFee;
                    $cPer = $subTotal*$chefCommissionPer/100;  
                    $chefCommission = $subTotal-$chefDiscount-$cPer;                    
                    $dPer = $deliveryFee*($deliveryCommissionPer/100);                    
                    $delCommission = ($deliveryFee!=0)?$deliveryFee-$dPer:0;
                    $revFromChef = $cPer+$serviceFee-$houseDiscount-$makemDiscount;
                    $revFromDel = ($deliveryFee!=0)?$dPer:0;
                }
                $d=date("m/d/Y",strtotime($deliveryDate));
                $createOrderData = [                    
                    'uuid' => Helper::getUuid(),
                    'chef_id' => $chefId,
                    'cust_id' => $custId,
                    'pick_del_option' => $pickDelOption,
                    'delivery_by' => $deliveryBy,
                    'payment_method' =>1,
                    'delivery_date' => date("Y-m-d",strtotime($deliveryDate)),
                    'delivery_time' => $pickDelTime,
                    'sub_total' => $subTotal,
                    'chef_discount' => $chefDiscount,
                    'house_discount' => $houseDiscount,
                    'makem_discount' => $makemDiscount,
                    'service_fee' => $serviceFee,
                    'delivery_fee' => $deliveryFee,
                    'tax_fee' => $taxFee,
                    'total' => $total,
                    'tip_fee' => $tipFee,
                    'pay_total' => $grandTotal,
                    'chef_commission_fee' => $chefCommission,
                    'delivery_commission_fee' => $delCommission,
                    'revenue_from_chef' => $revFromChef, 
                    'revenue_from_delivery' => $revFromDel,
                    'created_at_timezone' =>   $request->timezone 

                ];
                
                $orderRec=Order::create($createOrderData);
                              
                foreach ($order as $v) {
                    $optionTotal=0;  
                    if(!empty($v['menu_id'])){
                        if($v['option']!=NULL){                            
                            foreach($v['option'] as $option){                                
                                $optionTotal += $option['rate'];                     
                            }
                        }
                        $tot = $v['quantity'] * ($v['price'] + $optionTotal);                    
                        $orderItemData=[
                            'order_id'=>$orderRec->id,
                            'menu_id'=>$v['menu_id'],
                            'qty'=>$v['quantity'],
                            'rate'=>$v['price'],
                            'option_rate'=>$optionTotal,
                            'total' => $tot,
                            'notes'=>$v['instruction']
                        ];                        
                        $orderItemRec=OrderItems::create($orderItemData);
                        if($v['option']!=NULL){
                            foreach($v['option'] as $option){
                                $orderItemOptionData=[
                                    'order_item_id'=>$orderItemRec->id,
                                    'option'=>$option['option'],
                                    'rate'=>$option['rate']
                                ];
                                $orderItemOptionId=OrderItemOptions::create($orderItemOptionData);    
                            }
                        }
                    }                
                }
                $orderLocationData=[
                    'order_id'=>$orderRec->id,
                ];
                if($pickDelOption==1){
                    $orderLocationData['pickup_address']=Location::chefAddress($chefId);
                }else{
                    if($deliveryBy==1)
                        $orderLocationData['customer_address']=CustLocation::customerAddress($custId);
                    else
                        $orderLocationData['pickup_address']=Location::chefAddress($chefId);
                        $orderLocationData['customer_address']=CustLocation::customerAddress($custId);
                }                
                OrderLocation::create($orderLocationData);
                $paymentData=[
                    'order_id'=>$orderRec->id,
                ];
                CashPayment::create($paymentData);

                $updateOrderData=[
                    'status'=>Order::SUCCESS
                ];
                Order::where('id', $orderRec->id)->update($updateOrderData);
                
                if(isset($orderData['coupon_id'])){
                    $couponId = $orderData['coupon_id'];
                    $discount_by = $orderData['discount_by'];
                    if($discount_by==1){
                        Discount::where('id', $couponId)->update([
                        'total_used_coupons'=> DB::raw('total_used_coupons+1')]);
                    }elseif($discount_by==2){
                        VendorDiscount::where('id', $couponId)->update([
                        'total_used_coupons'=> DB::raw('total_used_coupons+1')]);
                    }else{
                        ChefDiscount::where('id', $couponId)->update([
                        'total_used_coupons'=> DB::raw('total_used_coupons+1')]);
                    }
                    $insertUsedCop = [
                        'discount_by'=>$orderData['discount_by'],
                        'coupon_id'=>$orderData['coupon_id'],
                        'user_id'=>$custId,
                        'order_id'=>$orderRec->id
                    ];
                    UsedCoupons::create($insertUsedCop);
                }
                Session::forget('cart.' . $d);
                Session::forget('order');
                Session::save();
                Session::flash('success', 'Payment successful!');
                DB::commit();            
                Helper::myLog('Online Payment store : finish');

                if(Helper::getLocCountry($chefId)=='142' && $request->invoice=='on'){                    
                    return redirect()->to('/invoice/'.$orderRec->id);                    
                }else{
                    return redirect('/cash-on-delivery');
                }
            }            
            
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Cash Payment store : exception');
            Helper::myLog($exception);
            Session::flash('error', 'Oops. Something went wrong. Please try again later..');
        }
    }
    
    public function paymentSuccess(){
        return view('frontend.payment.payment-success');
    }
    public function codSuccess(){
        return view('frontend.payment.cash-on-delivery');
    }
    public function invoice($orderId){
        
        $orderRec = Order::where('id',$orderId)->first();
        $chef = Users::select('display_name')->where('id',$orderRec->chef_id)->first();
        $cust = Users::select('display_name','email','mobile')->where('id',$orderRec->cust_id)->first();        
        $location = CustLocation::where('cust_id',$orderRec->cust_id)->first();     
        
        $pageData = [                
            'order'=>$orderRec,
            'chef'=>$chef,
            'cust'=>$cust,
            'location'=>$location,
           
        ];
        
        return view('frontend.payment.invoice',$pageData);
    }
    public function storeInvoice(Request $request){
        DB::beginTransaction();
        Helper::myLog('Mexico invoice store : start');
        try {

            $orderId = $request->order_id;
            $checkOrderId = MexicoInvoice::where('order_id',$orderId)->count();
            if ($checkOrderId > 0) {
                Helper::myLog('Mexico invoice store : name is exists');
                return response()->json(['status' => 409, 'message' => 'Invoice details is already exists!']);
            } else {             
                             
                $insertData = [
                    'order_id' => $orderId,
                    'rfc'=>$request->rfc,
                    'curp' => $request->curp,
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zipcode' => $request->zip_code,
                    'mobile' => $request->mobile,
                ];
                
                MexicoInvoice::create($insertData);
                DB::commit();
                Helper::myLog('Mexico invoice store : finish');
                Toastr::success(Config::get('constants.message.add'), 'Save');
                return response()->json(['status' => 200, 'message' => 'This information has been saved!']);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Helper::myLog('Mexico invoice store : exception');
            Helper::myLog($exception);
            Toastr::error(Config::get('constants.message.oops'), 'Error');
            return response()->json(['status' => 500, 'message' => 'This information has not been saved!']);
        } 
    }
}

