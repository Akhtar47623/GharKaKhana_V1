<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Crypt;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Helper;
use App\Model\Cuisine;
use App\Model\Location;
use App\Model\Group;
use App\Model\Tax;
use App\Model\Business;
use App\Model\Banking;
use App\Model\PickupDelivery;
use App\Model\ChefGelleryImage;
use App\Model\ChefProfileVideo;
use App\Model\ChefProfileBlog;
use App\Model\ChefCertificate;
use App\Model\CustLocation;
use App\Model\DeliveryDetails;
use App\Model\ChefRegistrationInfo;
use App\Model\Taxes;
use App\Model\ReviewRating;
use App\Model\ChefDiscount;
use App\Model\ChefUsedCoupons;
use App\Model\Discount;
use App\Model\VendorDiscount;
use App\Model\UsedCoupons;
use App\Model\Message;
use App\Model\Users;
use Toastr;
use Datatables;
use Socialite;
use \Carbon\Carbon;
use Redirect;
use Session,Config,Auth,File,DB,Cart;
use URL;
use PDF,Storage;

class ChefController extends ApiController {

	 public function chefProfile(Request $request){
          try 
        {
          
            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = [
                'chef_profile_id'=>'required',

            ]; 
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) 
            {

                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }

            $chef_id = $request->post('chef_profile_id');

            if($chef_id){

                $chefData = Users::select('id','uuid','display_name','profile','country_id','profile_id')->with('country:id,name')
                ->where('users.profile_id',$chef_id)->first();
                $chefData->profile=url('/public/frontend/images/users/'.$chefData->profile);
                

                $chefBusiness = Business::select('description','cuisine')->where('chef_id',$chefData->id)->first();
                $cuisines = Cuisine::select('id','name')->where('status','A')->get(); 

                if($chefBusiness){                                

                    $str = '';
                    $myArray = explode(',', $chefBusiness->cuisine);
                    foreach($cuisines as $c){
                        if (in_array($c->id, $myArray)){
                            $str=$str.$c->name;
                            $str=$str.', ';
                        }
                    }                                    
                    $chefBusiness->cuisine=rtrim($str,' ,');
                }

                $chefLocation = Location::select('city_id','state_id')->with('state:id,name','city:id,name')->where('chef_id',$chefData->id)->first();

                $chefVideoCount = ChefProfileVideo::where('chef_id',$chefData->id)->where('status','A')->count();

                $chefBlogCount = ChefProfileBlog::where('chef_id',$chefData->id)->where('status','A')->count();

                $certiData = ChefCertificate::select('certi_name','certi_authority','certi_from','certi_to','certi_url','image')->where('chef_id',$chefData->id)->where('status','A')->get();
                foreach ($certiData as $key => $value) {
                    $value->image=url('/public/frontend/images/certificate/'.$value->image);
                }

                $chefPicDel = PickupDelivery::select('options')->where('chef_id',$chefData->id)->first();
                if($chefPicDel->options == 1){
                    $chefPicDel->options = "Pickup";
                }else if($chefPicDel->options == 2){
                    $chefPicDel->options = "Pickup and Delivery";
                }else{
                    $chefPicDel->options = "Delivery";
                }
                $chefReview = ReviewRating::with('user')->where('chef_id',$chefData->id)->where('status',"2")
                                ->orderBy('chef_rating', 'DESC')->get();
                foreach ($chefReview as $key => $value) {
                    $value->user->profile_path=url('/public/frontend/images/users/'.$value->user->profile);
                }
                
                $chefRecentReview = ReviewRating::with('user')->where('chef_id',$chefData->id)->where('status',"2")
                                ->orderBy('updated_at', 'DESC')->limit(10)->get();
                foreach ($chefRecentReview as $key => $value) {
                    $value->user->profile_path=url('/public/frontend/images/users/'.$value->user->profile);
                }    
                
                $chefAvgRating = ReviewRating::where('chef_id',$chefData->id)->where('status',"2")->groupBy('chef_id')->avg('chef_rating');
                $chefNoOfRating = ReviewRating::where('chef_id',$chefData->id)->where('status',"2")->count();
                
                $chefItemCategory=Menu::select('id','item_category')->where('chef_id',$chefData->id)->groupBy('item_category')->get();
                $chefMainCategory=Menu::select('item_category')->where('chef_id',$chefData->id)->distinct('item_category')->get();
                $taxes = Taxes::select('service_fee_per','tax')->where('state_id',$chefLocation->state_id)->where('city_id',$chefLocation->city_id)->first(); 
                $mainCategory=array();
                foreach ($chefMainCategory as $value) {
                    $subCategory=Menu::select('item_type')->where('chef_id',$chefData->id)
                                                ->where('item_category',$value->item_category)
                                                ->where('item_visibility','1')
                                                ->distinct('item_type')->pluck('item_type')->toArray();
                    $mCat = ['subcategory'=>$subCategory,'items'=>[]];             
                    foreach ($subCategory as $value1) {
                        $items = Menu::with('menuOptions','menuSchedule','menuNutrition')->where('chef_id',$chefData->id)
                                    ->where('item_category',$value->item_category)
                                    ->where('item_type',$value1)
                                    ->where('item_visibility','1')
                                    ->get();
                        
                        array_push($mCat['items'],$items);
                    }
                    array_push($mainCategory,$mCat);            
                }
                foreach($mainCategory as $mainCat){
                    foreach($mainCat['items'] as $itm){
                        foreach($itm as $i){
                            $i->photo = url('/public/frontend/images/menu/'.$i->photo);
                            if(!empty($i->menuNutrition)){
                                $i->menuNutrition->total_fat_dv=round($i->menuNutrition->total_fat*100/78).'%';
                                $i->menuNutrition->saturated_fat_dv=round($i->menuNutrition->saturated_fat*100/20).'%';
                                $i->menuNutrition->cholestero_dv=round($i->menuNutrition->cholesterol*100/300).'%';
                                $i->menuNutrition->sodium_dv=round($i->menuNutrition->sodium*100/2300).'%';
                                $i->menuNutrition->total_carbohydrates_dv=round($i->menuNutrition->total_carbohydrates*100/275).'%';
                                $i->menuNutrition->dietry_fiber_dv=round($i->menuNutrition->dietry_fiber*100/28).'%';
                                $i->menuNutrition->added_sugar_dv=round($i->menuNutrition->added_sugar*100/50).'%';
                                $i->menuNutrition->protein_dv=round($i->menuNutrition->protein*100/50).'%';
                            }
                        }
                    }
                }
                $groups = Group::where('chef_id',$chefData->id)->get();       
                $gelleryData = ChefGelleryImage::where('chef_id',$chefData->id)->get(); 
                foreach ($gelleryData as $key => $value) {
                    $value->filename=url('/public/frontend/images/gellery/'.$value->filename);
                }
                $countryId=Users::select('country_id')->where('id',$chefData->id)->first();
                $currency=[];
                if($countryId){
                    $currency = Countries::where('id',$countryId->country_id)->first();
                }    
                $pageData = [
                    'chefData'=>$chefData,
                    'chefBusiness'=>$chefBusiness,
                    'chefLocation'=>$chefLocation,
                    'certiData'=>$certiData,
                    'chefReview'=>$chefReview,
                    'chefAvgRating'=>$chefAvgRating,
                    'chefNoOfRating'=>$chefNoOfRating,
                    'chefRecentReview'=>$chefRecentReview,
                    'chefPicDel'=>$chefPicDel,
                    'chefMainCategory'=>$chefMainCategory,
                    'mainCategory'=>$mainCategory,
                    'gelleryData'=>$gelleryData,             
                    'groups'=>$groups,
                    'currency'=>$currency,                    
                    'chefVideoCount'=>$chefVideoCount,
                    'chefBlogCount'=>$chefBlogCount,
                    'taxes'=>$taxes
                ];
                return $this->jsonResponse(['status' => 1, 'msg' => 'Chef Profile','data'=>$pageData]);

            }
        }catch (\Illuminate\Database\QueryException $ex){
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        } 
        
        
    }
     public function chefProfileVideo(Request $request){
         try 
        {
          
            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = ['chef_profile_id'=>'required']; 
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) 
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }

            $chef_id = $request->post('chef_profile_id');

            if($chef_id){

                $chef=Users::select('id')->where('profile_id',$chef_id)->first();
                $videoData = ChefProfileVideo::where('chef_id',$chef->id)->where('status','A')->get();
                $pageData = ['videoData'=>$videoData];
                               
                return $this->jsonResponse(['status' => 1, 'msg' => 'Chef Profile Video','data'=>$pageData]);

            }
        }catch (\Illuminate\Database\QueryException $ex){
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        } 
        
    }
    public function chefProfileBlog(Request $request){
         try 
        {
          
            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = ['chef_profile_id'=>'required']; 
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails()) 
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }

            $chef_id = $request->post('chef_profile_id');

            if($chef_id){

                $chef=Users::select('id')->where('profile_id',$chef_id)->first();
                $blogData = ChefProfileBlog::where('chef_id',$chef->id)->where('status','A')->get();
                foreach ($blogData as $key => $value) {
                    $value->image=url('/public/frontend/images/blog/'.$value->image);
                }
                $pageData = ['blogData'=>$blogData];
                               
                return $this->jsonResponse(['status' => 1, 'msg' => 'Chef Profile Video','data'=>$pageData]);

            }
        }catch (\Illuminate\Database\QueryException $ex){
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        } 
        
    }
}