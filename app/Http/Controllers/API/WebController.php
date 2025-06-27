<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Model\CountryLocation;
use App\Model\Users;
use App\Model\Roles;
use App\Model\Countries;
use App\Model\Menu;
use App\Model\Options;
use App\Model\States;
use App\Model\Cities;
use App\Model\Cuisine;
use App\Model\Tax;
use App\Model\Business;
use App\Model\Banking;
use App\Model\ChefGelleryImage;
use App\Model\ChefProfileVideo;
use App\Model\ChefCertificate;
use App\Model\CustLocation;
use App\Model\ReviewRating;
use App\Model\Categories;
use App\Model\Order;
use App\Model\Message;
use App\Model\Ticket;
use App\Model\TicketMessage;
use App\Model\TicketCategory;
use App\Model\ContactUs;
use App\Model\Taxes;
use App\Model\Schedule;
use \Carbon\Carbon;
use Config;
use Auth;
use DB;
use App\Model\Helper;
class WebController extends ApiController {

    //Landing Page Country List
    public function getCountry(Request $request) {

        try {
            $countryList=CountryLocation::with('country:id,name')->select('country_id','address')->get();
            return $this->jsonResponse(['status' => 1, 'msg' => 'Country List','data'=>$countryList]);

        } catch (\Illuminate\Database\QueryException $ex) {
             return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);

        }
    }

    public function home(Request $request){
        try
        {

            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = [
                            'country'=>'required',
                            'state'=>'required',
                            'city' => 'required',
                            'address'=>'required',
                          ];
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails())
            {

                $messages = $validator->messages();

                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }
            $city= Helper::getCityId($request->post('country'),$request->post('state'),$request->post('city'));
            if(!empty($city))
            {
                $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];

                $chefData = Users::with('ratings','chefLocation','chefBussiness')
                        ->with(['chefMenu'=>function($query){
                            $query->orderByRaw('RAND()')->first();
                        }])
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        })
                        ->whereHas('chefMenu')
                        ->whereHas('chefBussiness')
                        ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id','users.country_id')
                        ->where($whereClouser)
                        ->inRandomOrder()->limit(6)->get();

                foreach ($chefData as $menu)
                {
                    $chefLoc =$menu->chefLocation->address;
                    $custLoc = $request->post('address');
                    $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                    $menu['distance']=$miles;

                    foreach($menu->chefMenu as $m){
                        $m['photo']=url('/public/frontend/images/menu/'.$m['photo']);
                        $m['available_date']=Schedule::sch($m->id);
                    }
                }
                $cuisines = Cuisine::select('id','name')->where('status','A')->get();
                foreach ($chefData as $value) {
                    $value->profile=url('/public/frontend/images/users/'.$value->profile);
                    $value->rating=round($value->ratings->avg('chef_rating'));

                    $str = '';
                    $myArray = explode(',', $value->chefBussiness->cuisine);
                    foreach($cuisines as $c){
                        if (in_array($c->id, $myArray)){
                            $str=$str.$c->name;
                            $str=$str.', ';
                        }
                    }
                    $value->cuisines=rtrim($str,' ,');
                }
                $countryId = Helper::getCountryId($request->post('country'));
                $currency = Countries::where('id',$countryId)->first();
                $categories = Categories::where('country_id',$countryId)->inRandomOrder()->limit(6)->get();
                $taxes = Taxes::select('service_fee_per','tax')->where('city_id',$city)->first();
                $currency=[];
                if($countryId)
                {
                    $currency = Countries::where('id',$countryId)->first();
                }

                if(count($chefData))
                {
                    $chefData = $chefData->makeHidden(['ratings','chefLocation','chefBussiness']);
                    $pageData = ['chefData'=>$chefData,'currency'=>$currency,'categories'=>$categories,'countryId'=>$countryId,'taxes'=>$taxes];
                    if(auth('front')->check() && auth('front')->user()->type == "Customer")
                    {
                        $review=ReviewRating::with('user')->where('cust_id',auth('front')->user()->id)
                        ->where('status','0')
                        ->where('created_at','>=',Carbon::now()->subdays(15))
                        ->first();
                        $pageData['review']=$review;
                    }

                    return $this->jsonResponse(['status' => 1, 'msg' => 'Home Page Data','data'=>$pageData]);

                }
                else
                {

                    return $this->jsonResponse(['status' => 0, 'msg' => 'Not Available','data'=>$pageData]);
                }
            }else{

                return $this->jsonResponse(['status' => 0, 'msg' => 'Not Available','data'=>$pageData]);

            }

        }
        catch (\Illuminate\Database\QueryException $ex)
        {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }
    public function allCategory(Request $request){
        try
        {

            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = ['country'=>'required'];
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails())
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }
            $countryId = Helper::getCountryId($request->post('country'));
            $categories = Categories::where('country_id',$countryId)->get();
            foreach ($categories as $key => $value) {
                $value->image=url('/public/backend/images/category/'.$value->image);
            }
            $pageData['categories']=$categories;
             return $this->jsonResponse(['status' => 1, 'msg' => 'All Category','data'=>$pageData]);
        }
        catch (\Illuminate\Database\QueryException $ex)
        {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }
    public function allChef(Request $request){
        try
        {

            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = [
                            'country'=>'required',
                            'state'=>'required',
                            'city' => 'required',

                          ];
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails())
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }
            $city= Helper::getCityId($request->post('country'),$request->post('state'),$request->post('city'));
            if(!empty($city))
            {
                $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];

                $chefData = Users::with('ratings','chefLocation','chefBussiness')
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        })
                        ->whereHas('chefMenu')
                        ->whereHas('chefBussiness')
                        ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id')
                        ->where($whereClouser)
                        ->get();
                $cuisines = Cuisine::select('id','name')->where('status','A')->get();
                foreach ($chefData as $value) {
                    $value->profile=url('/public/frontend/images/users/'.$value->profile);
                    $value->rating=round($value->ratings->avg('chef_rating'));

                    $str = '';
                    $myArray = explode(',', $value->chefBussiness->cuisine);
                    foreach($cuisines as $c){
                        if (in_array($c->id, $myArray)){
                            $str=$str.$c->name;
                            $str=$str.', ';
                        }
                    }
                    $value->cuisines=rtrim($str,' ,');
                }
                $chefData = $chefData->makeHidden(['ratings','chefLocation','chefBussiness']);
                $pageData['chefData']=$chefData;
                return $this->jsonResponse(['status' => 1, 'msg' => 'All Chef','data'=>$pageData]);
            }else{
                return $this->jsonResponse(['status' => 0, 'msg' => 'No Data Found']);
            }

        }
        catch (\Illuminate\Database\QueryException $ex)
        {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }
     public function autoCompleteSearch(Request $request)
    {
         try
        {

            if($request->method() == 'GET')
            {
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.'], 400);
            }
            $validArray = [
                            'country'=>'required',
                            'state'=>'required',
                            'city' => 'required',
                            'term' => 'required'
                          ];
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails())
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }
            $city= Helper::getCityId($request->post('country'),$request->post('state'),$request->post('city'));

            $search=  $request->post('term');

            if(!empty($city))
            {

                //Search Menu
                $menu = Menu::with('chefLocation')
                ->whereHas('chefLocation', function($chefLocation) use ($city) {
                    $chefLocation->where('city_id','=',$city);
                })
                ->where(function ($query) use($search) {
                    $query->where('item_name','LIKE','%' . $search . '%')
                    ->orWhere('item_category','LIKE','%' . $search . '%')
                    ->orWhere('item_type','LIKE', '%' . $search . '%');
                })
                ->groupBy('item_category')->limit(5)->get();

                if(!$menu->isEmpty()){
                    $f=0;
                    foreach($menu as $m){
                        $new_row['heading']= "Category";
                        $new_row['title']= $m->item_category;
                        $new_row['image']= url('public/frontend/images/menu/'.$m->photo);
                        $new_row['url']= url('search/menu/'.$m->item_category.'/'.$search);
                        $row_set[] = $new_row; //build an array
                        $f++;

                    }
                    if($f>1){
                        $new_row['heading']= "Category";
                        $new_row['title']= 'See all category';
                        $new_row['image']= url('public/frontend/images/all-category.jpg');
                        $new_row['url']= url('search/menu/all/'.$search);
                        $row_set[] = $new_row; //build an array
                    }
                }


                //Search Chef
                $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
                $chef = Users::with('chefLocation','chefMenu')
                ->whereHas('chefLocation', function($chefLocation) use ($city) {
                    $chefLocation->where('city_id','=',$city);
                })
                ->whereHas('chefMenu')
                ->select('users.*')
                ->where($whereClouser)
                ->where('display_name','LIKE',"%{$search}%")
                ->orderBy('created_at','DESC')->limit(5)->get();

                if(!$chef->isEmpty()){
                    $s=0;
                    foreach($chef as $c){
                        $new_row['heading']= "Chef List";
                        $new_row['title']= $c->display_name;
                        $new_row['image']= url('public/frontend/images/users/'.$c->profile);
                        $new_row['url']= url('chef-profile/'.$c->profile_id);
                        $row_set[] = $new_row; //build an array
                        $s++;
                    }
                    if($s>1){
                        $new_row['heading']= "Chef List";
                        $new_row['title']= 'See all chef for: '.$search;
                        $new_row['image']= url('public/frontend/images/all-chef.jpg');
                        $new_row['url']= url('search/chef/all/'.$search);
                        $row_set[] = $new_row; //build an array
                    }
                }
                if($menu->isEmpty()&&$chef->isEmpty()){

                        $new_row['heading']= "Category Or Chef";
                        $new_row['title']= 'No Result Found';
                        $new_row['image']= url('public/frontend/images/no-result.png');
                        $row_set[] = $new_row; //build an array
                }
            }
            return $this->jsonResponse(['status' => 1, 'msg' => 'Search Auto Complete','data'=>$row_set]);

        }
        catch (\Illuminate\Database\QueryException $ex)
        {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }
    }
    public function search(Request $request,$display='',$cat='',$str=''){
        try {

            if($request->method() == 'GET'){
                return $this->jsonResponse(['status' => 0, 'msg' => $request->method() . ' method not allowed.']);
            }
             $validArray = [
                            'country'=>'required',
                            'state'=>'required',
                            'city' => 'required',
                            'display'=> 'required',
                            'category' => 'required',
                            'search'=> 'required'
                          ];
            $validator = Validator::make($request->all(), $validArray);
            if ($validator->fails())
            {
                $messages = $validator->messages();
                return $this->jsonResponse(['status' => 0, 'msg' => implode(" ", $messages->all()), 'error_log' => 'Validation fail'], 400);
            }
            $search = $request->search;
            $displayBy = $request->display;
            $cat = $request->category;


            $cuisines = Cuisine::select('id','name')->where('status','A')->get();
            if($displayBy=='menu'){

                $displayby=0;
                $city= Helper::getCityId($request->country,$request->state,$request->city);

                if(!empty($city)){


                    $menu = Menu::with('chefLocation','ratings','menuSchedule','service')
                            ->whereHas('chefLocation', function($chefLocation) use ($city) {
                                $chefLocation->where('city_id','=',$city);
                            });
                    if($cat!='nearby'){
                        if($cat=="all"){
                                $menu = $menu->where(function ($query) use($search,$cat) {
                                    $query->where('item_name','LIKE','%' . $search . '%')
                                    ->orWhere('item_category','LIKE','%' . $search . '%')
                                    ->orWhere('item_type','LIKE', '%' . $search . '%');
                                });
                        }else{
                                $menu = $menu->where(function ($query) use($search,$cat) {
                                    $query->where('item_category','LIKE', '%' . $cat . '%')
                                    ->orWhere('item_type','LIKE', '%' . $cat . '%');

                                });
                        }
                    }
                    if($request->has('rating')){
                        $rate = $request->rating;
                        $menu = $menu->whereHas('ratings', function($chefRatings)use($rate) {
                            $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                        });
                    }
                    if($request->has('service')){
                        $service = $request->service;
                        $menu = $menu->whereHas('service', function($chefService)use($service) {
                            $chefService->where('options',$service)->orWhere('options',2);
                        });
                    }
                    //Price Filter
                    if($request->has('min_price') && $request->has('max_price')){
                        $menu = $menu->whereBetween('rate', [$request->min_price, $request->max_price]);
                    }

                    //Menu data to add distance
                    $menu = $menu->get();
                    foreach ($menu as $m) {

                        $chefLoc = $m->chefLocation->address;
                        $custLoc = $request->address;
                        $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                        $m['distance']=$miles;
                    }

                    //Available Date
                    foreach ($menu as $m) {
                        $sch=$m->menuSchedule;
                        if(!empty($sch)){
                            if($sch->mon=="1"){
                                $day=1;
                            }else if($sch->tue=="1"){
                                $day=2;
                            }else if($sch->wed=="1"){
                                $day=3;
                            }else if($sch->thu=="1"){
                                $day=4;
                            }else if($sch->fri=="1"){
                                $day=5;
                            }else if($sch->sat=="1"){
                                $day=6;
                            }else if($sch->sun=="1"){
                                $day=0;
                            }
                            $startdate = Carbon::now()->addDay($sch->lead_time);
                            if( $sch->recurring==1)
                            {
                                $date='';
                                for($i=1;$i<=14;$i++){
                                    if($startdate->dayOfWeek == $day){
                                        $date=$startdate;
                                        break;
                                    }else{
                                        $startdate=$startdate->addDay(1);
                                    }
                                }
                            }else{
                                $date='';
                                for($i=1;$i<=7;$i++){
                                    if($startdate->dayOfWeek == $day){
                                        $date=$startdate;
                                        break;
                                    }else{
                                        $startdate=$startdate->addDay(1);
                                    }
                                }
                            }
                            if($date->isToday()){
                               $m['avilable_date']="Today";
                            }else{
                                $m['avilable_date']=$date->toDateString();
                            }
                        }
                    }

                    //Distance Filter
                    if($request->has('min_miles') && $request->has('max_miles')){
                        $menu = $menu->whereBetween('distance',[$request->min_miles, $request->max_miles ]);
                    }


                    if(!$menu->isEmpty()){
                        foreach($menu as $m){
                            $chef[] = $m->chef_id;
                        }
                    }else{$chef=[];}

                    $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
                    $chefData = Users::with('ratings','chefLocation','chefBussiness','chefMenu')
                    ->whereHas('chefLocation', function($chefLocation) use ($city) {
                        $chefLocation->where('city_id','=',$city);
                    })
                    ->whereHas('chefMenu')
                    ->select('users.id','users.uuid','users.display_name','users.profile','users.profile_id')
                    ->where($whereClouser)
                    ->whereIn('id',$chef);

                    if($request->has('rating')){
                        $rate = $request->rating;
                        $chefData = $chefData->whereHas('ratings', function($chefRatings)use($rate) {
                            $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                        });
                    }
                    $chefData = $chefData->get();
                    foreach ($chefData as $value) {

                        $value->profile=url('/public/frontend/images/users/'.$value->profile);
                        $value->rating=round($value->ratings->avg('chef_rating'));

                        $str = '';
                        $myArray = explode(',', $value->chefBussiness->cuisine);
                        foreach($cuisines as $c){
                            if (in_array($c->id, $myArray)){
                                $str=$str.$c->name;
                                $str=$str.', ';
                            }
                        }
                        $value->cuisines=rtrim($str,' ,');
                    }
                    if($request->has('popularity')){
                        $popularity = $request->popularity;
                        $chefData = $chefData->sortByDesc(function($users) {
                            return $users->ratings()->avg('chef_rating');
                        });
                    }
                    $menu = $menu->makeHidden(['chefLocation','ratings','menuSchedule','service']);
                }
            }else{
                $displayby=1;
                $city= Helper::getCityId($request->country,$request->state,$request->city);

                if(!empty($city)){

                    if($cat=="all"){
                        $whereClouser = ['users.type'=>'Chef','users.status'=>'A'];
                        $chefData = Users::with('chefLocation','ratings','chefMenu')
                        ->whereHas('chefLocation', function($chefLocation) use ($city) {
                            $chefLocation->where('city_id','=',$city);
                        })
                         ->whereHas('chefMenu')
                        ->select('users.*')
                        ->where($whereClouser)
                        ->where('display_name','LIKE',"%{$search}%")
                        ->orderBy('created_at','DESC');

                        if($request->has('service')){
                        $service = $request->service;
                            $menu = $menu->whereHas('service', function($chefService)use($service) {
                                $chefService->where('options',$service)->orWhere('options',2);
                            });
                        }
                        if($request->has('rating')){
                            $rate = $request->rating;
                            $chefData = $chefData->whereHas('ratings', function($chefRatings)use($rate) {
                                $chefRatings->havingRaw('ROUND(AVG(chef_rating)) >= '.$rate);
                            });
                        }
                        $chefData = $chefData->get();
                        foreach ($chefData as $value) {

                            $value->profile=url('/public/frontend/images/users/'.$value->profile);
                            $value->rating=round($value->ratings->avg('chef_rating'));

                            $str = '';
                            $myArray = explode(',', $value->chefBussiness->cuisine);
                            foreach($cuisines as $c){
                                if (in_array($c->id, $myArray)){
                                    $str=$str.$c->name;
                                    $str=$str.', ';
                                }
                            }
                            $value->cuisines=rtrim($str,' ,');
                        }
                        if($request->has('popularity')){
                            $popularity = $request->popularity;
                            $chefData = $chefData->sortByDesc(function($users) {
                                return $users->ratings()->avg('chef_rating');
                            });
                        }

                        if(!$chefData->isEmpty()){
                            foreach($chefData as $m){
                                $chef[] = $m->id;
                            }
                            $menu = Menu::with('chefLocation')
                            ->whereHas('chefLocation', function($chefLocation) use ($city) {
                                $chefLocation->where('city_id','=',$city);
                            })
                            ->whereIn('chef_id',$chef)->get();
                            $menu = $menu->makeHidden(['chefLocation']);
                            foreach ($menu as $m) {
                                $chefLoc = $m->chefLocation->address;
                                $custLoc = $request->address;
                                $miles = Helper::geoLocationDistance($chefLoc,$custLoc);
                                $m['distance']=$miles;
                            }

                            //Available Date
                            foreach ($menu as $m) {
                                $sch=$m->menuSchedule;
                                if(!empty($sch)){
                                    if($sch->mon=="1"){
                                        $day=1;
                                    }else if($sch->tue=="1"){
                                        $day=2;
                                    }else if($sch->wed=="1"){
                                        $day=3;
                                    }else if($sch->thu=="1"){
                                        $day=4;
                                    }else if($sch->fri=="1"){
                                        $day=5;
                                    }else if($sch->sat=="1"){
                                        $day=6;
                                    }else if($sch->sun=="1"){
                                        $day=0;
                                    }
                                    $startdate = Carbon::now()->addDay($sch->lead_time);
                                    if( $sch->recurring==1)
                                    {
                                        $date='';
                                        for($i=1;$i<=14;$i++){
                                            if($startdate->dayOfWeek == $day){
                                                $date=$startdate;
                                                break;
                                            }else{
                                                $startdate=$startdate->addDay(1);
                                            }
                                        }
                                    }else{
                                        $date='';
                                        for($i=1;$i<=7;$i++){
                                            if($startdate->dayOfWeek == $day){
                                                $date=$startdate;
                                                break;
                                            }else{
                                                $startdate=$startdate->addDay(1);
                                            }
                                        }
                                    }
                                    if($date->isToday()){
                                       $m['avilable_date']="Today";
                                    }else{
                                        $m['avilable_date']=$date->toDateString();
                                    }
                                }

                            }
                            $menu = $menu->makeHidden(['menuSchedule']);

                                    //Distance Filter
                            if($request->has('min_miles') && $request->has('max_miles')){
                                $menu = $menu->whereBetween('distance',[$request->min_miles, $request->max_miles ]);
                            }
                        }else{$menu=[];}

                    }
                }
            }

            //Sort Menu
            if($request->price=='desc'){
                $menu = $menu->sortByDesc('rate');
            }
            if($request->price=='asc'){
                $menu = $menu->sortBy('rate');
            }

            if($request->has('recently')){
                $menu = $menu->sortByDesc('created_at');
            }
            if($request->availability=='asc'){
                $menu = $menu->sortBy('avilable_date');
            }

            // Country,State, Currency
            $countryId = Helper::getCountryId($request->country);
            $currency=[];
            if(!empty($countryId)){
                $currency = Countries::where('id',$countryId)->first();
            }
             $city = Helper::getCityId($request->country,$request->state,$request->city);

            $taxes = Taxes::select('service_fee_per','tax')->where('city_id',$city)->first();
            $countryId = Helper::getCountryId($request->country);
            $categories = Categories::where('country_id',$countryId)->inRandomOrder()->limit(12)->get();
            foreach ($categories as $value) {
                $value->image=url('/public/backend/images/category/'.$value->image);
            }
            $chefData = $chefData->makeHidden(['ratings','chefLocation','chefBussiness','chefMenu']);
            foreach ($menu as $value) {
                $value->photo=url('/public/frontend/images/menu/'.$value->photo);
            }
            $pageData = [
                    'displayby'=>$displayby,
                    'menu'=>$menu,
                    'chefData'=>$chefData,
                    // 'cuisines'=>$cuisines,
                    'search'=>$search,
                    'currency'=>$currency,
                    'taxes'=>$taxes,
                    'categories'=>$categories

                ];
            return $this->jsonResponse(['status' => 1, 'msg' => 'Search Result','data'=>$pageData]);


        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->jsonResponse(['status' => 0, 'msg' => 'Oops Something went wrong please try again.', 'error_log' => $ex->getMessage()]);
        }


    }
}


