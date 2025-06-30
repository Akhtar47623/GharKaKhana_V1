<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Countries;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
     public function __construct()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }
   public function checkout()
    {
        $countries = Countries::pluck('name', 'id');
        $pageData = ["title" => Config::get('constants.title.countrylocation_add'),'countries' => $countries];
        return view('frontend.checkout.checkout-details',$pageData); // create this Blade file
    }

    public function placeOrder(){
           Session::forget('cart');

        return redirect()->route('checkout')->with('success', 'Order placed successfully!');
    }

    public function prepareOrder(Request $request)
    {
        try {
            $cart = session('cart');

            if (empty($cart)) {
                return redirect()->back()->with('error', 'Your cart is empty.');
            }

            $user = auth('front')->user();
            $custId = $user->id;

            // Flatten the cart to get the first item (to extract common chef_id)
            $firstItem = collect($cart)->flatten(1)->first();
            $chefId = $firstItem['chef_id'] ?? null;

            $subTotal = 0;

            foreach ($cart as $date => $items) {
                foreach ($items as $item) {
                    $optionTotal = 0;

                    if (!empty($item['option'])) {
                        foreach ($item['option'] as $opt) {
                            $optionTotal += $opt['rate'];
                        }
                    }

                    $subTotal += $item['quantity'] * ($item['price'] + $optionTotal);
                }
            }

            // Example static values (could be dynamic/config-driven)
            $serviceFee = 0;
            $deliveryFee = 100;
            $taxPer = 5;
            $taxFee = ($subTotal * $taxPer) / 100;
            $tipFee = 0;

            $houseDiscount = 0;
            $chefDiscount = 0;
            $makemDiscount = 0;

            $chefCommissionPer = 20;
            $deliveryCommissionPer = 10;

            $orderData = [
                'chef_id' => $chefId,
                'cust_id' => $custId,
                'delivery_date' => $request->delivery_date,
                'pick_del_option' => $request->pick_del_option,
                'pick_del_time' => $request->pick_del_time,
                'delivery_by' => $request->delivery_by,

                'chef_commission_per' => $chefCommissionPer,
                'delivery_commission_per' => $deliveryCommissionPer,

                'sub_total' => $subTotal,
                'chef_discount' => $chefDiscount,
                'house_discount' => $houseDiscount,
                'makem_discount' => $makemDiscount,
                'service_fee' => $serviceFee,
                'delivery_fee' => $deliveryFee,
                'tax_fee' => $taxFee,
                'tax_per' => $taxPer,
                'tip_fee' => $tipFee,

                // Optional coupon if applied
                'coupon_id' => $request->coupon_id ?? null,
                'discount_by' => $request->discount_by ?? null,
            ];

            $order = [
                'orderData' => $orderData,
                'cartItems' => $cart // Preserve full cart for item creation
            ];

            session(['order' => $order]);

            return redirect()->route('cash.post'); // Or card.post, based on payment selection

        } catch (\Exception $e) {
            \Log::error('Prepare Order Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while preparing the order.');
        }

    }

}
