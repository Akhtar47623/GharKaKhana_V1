<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Config;
use Cookie;
use App\Model\Countries;
use App\Model\CountryLocation;
use App\Model\States;
use App\Model\Cities;
use App\Model\Message;
use App\Model\TicketMessage;
use URL;
class Helper extends Model
{
    public static function getLocCity()
    {
        if(Cookie::get('location')){
            $location=unserialize(Cookie::get('location'));
            $country = Countries::select('id')->where('name',$location['country'])->first();
            if(!empty($country)){
                $state = States::select('id')->where('name',$location['state'])
                    ->where('country_id',$country->id)->first();
            }
            if(!empty($state)){
                $cityState = Cities::select('id','state_id')->where('name',$location['city'])
                        ->where('state_id',$state->id)->first();
            }
            $cityId='';
            if(!empty($cityState)){
                $cityId = $cityState->id;
                return $cityId;
            }else{
                return $cityId;
            }
        }
    }
    public static function getLocCountry()
    {
        if(Cookie::get('location')){
            $location=unserialize(Cookie::get('location'));
            $country = Countries::select('id')->where('name',$location['country'])->first();
            $countryId='';
            if(!empty($country)){
                return $country->id;
            }else{
                return $countryId;
            }
        }
    }
    public static function geoLocationDistance($s,$d)
    {
        $d =str_replace( ' ','+',str_replace( ',','',$d));
        $s = str_replace(' ','+',str_replace( ',','',$s));
        $curl = curl_init();
        $str="https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$s."&destinations=".$d."&key=AIzaSyDlkfpkyKX2wb_cRMmqVWthoadHuegCdoc";
        curl_setopt_array($curl, array(
          CURLOPT_URL => $str,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: 40ad1c4f-b5c9-bd91-f81b-f2276fd45c09"
            ),
        ));
        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return 'Not Found';
        } else {
            $respo=json_decode($response);
            if(   empty($respo->rows) ||  empty($respo->rows[0]->elements) || $respo->rows[0]->elements[0]->status === 'ZERO_RESULTS'){
                        return 'Not Found';
            }else{
                $miles=$respo->rows[0]->elements[0]->distance->text;
                $miles=substr($miles, 0, strpos($miles, " "));
                return $miles;
            }
        }
    }
    public static function getLocation()
    {
        if(Cookie::get('location')){
            $location=unserialize(Cookie::get('location'));
            return $location['address'];
        }
    }
    public static function countryList()
    {
        $list=CountryLocation::with('country')->select('country_id')->get();
        return $list;
    }
    public static function getLocState()
    {
        if(Cookie::get('location')){
            $location=unserialize(Cookie::get('location'));
            $country = Countries::select('id')->where('name',$location['country'])->first();
            $state = States::select('id')->where('name',$location['state'])
                    ->where('country_id',$country->id)->first();
            $stateId='';
            if(!empty($state)){
                return $state->id;
            }else{
                return $stateId;
            }

        }
    }
    public static function unreadedConversations(){
        $totChatMsg = Message::where('to_id',auth('chef')->user()->id)->where('seen','0')->count();
        $totTicMsg = TicketMessage::leftjoin('ticket','ticket_message.ticket_id','ticket.id')
        ->where('to_id',auth('chef')->user()->id)
        ->where('status','1')
        ->where('seen','0')->count();
        return $totChatMsg + $totTicMsg;
    }
    public static function unreadOrderConversation(){
        $totaltMessage=Message::where('to_id',auth('front')->user()->id)->where('seen','0')->count();
        $ticketMessage=TicketMessage::leftjoin('ticket','ticket.id','ticket_message.ticket_id')
        ->where('to_id',auth('front')->user()->id)
        ->where('status','1')
        ->where('seen','0')->count();
        return $totaltMessage + $ticketMessage;
    }
    public static function getUuid()
    {
        $query = DB::select('select uuid() AS uuid');

        return $query[0]->uuid;
    }

    public static function myLog($message)
    {
        Log::info($message);
    }

    public static function slugify($string)
    {
        $string = utf8_encode($string);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
        $string = str_replace(' ', '-', $string);
        $string = trim($string, '-');
        $string = strtolower($string);
        if (empty($string)) {
            return 'n-a';
        }
        return $string;
    }

    static function replaceNullWithEmptyString($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = self::replaceNullWithEmptyString($value);
            else {
                if (is_null($value))
                    $array[$key] = "";
            }
        }
        return $array;
    }

    static function randomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString . time();
    }

    //$digits = '';
    static function randomDigits($length){
        $numbers = range(0,9);
        shuffle($numbers);
        for($i = 0; $i < $length; $i++){
            global $digits;
            $digits .= $numbers[$i];
        }
        return $digits;
    }
    static function sendMailAdmin($data, $filename, $subject,$to_email ='')
    {

        try {

            $from_email = 'donotreply@prepbychef.com';
            $from_name = 'Prep By Chef';
                if($to_email == '')
                {
                    $to_email = 'admin@prepbychef.com';
                }
            $to_name = 'toname';
            $e=Mail::send($filename, ['data' => $data], function ($message) use ($from_name, $from_email, $subject, $to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject($subject);
                $message->from($from_email, $from_name);

            });

        } catch (\Exception $exception) {
            self::myLog($subject . ' : exception');
            self::myLog($exception);
        }
    }
    static function sendMailInvoice($data, $filename, $subject,$to_email ='',$file)
    {

        try {

            $from_email = Config::get('constants.company.email');
            $from_name = 'Prep By Chef';
                if($to_email == '')
                {
                    $to_email = 'admin@prepbychef.com';
                }
            $to_name = 'toname';
            $e=Mail::send($filename, ['data' => $data], function ($message) use ($from_name, $from_email, $subject, $to_name, $to_email,$file) {
                $message->to($to_email, $to_name)
                    ->subject($subject);
                $message->from($from_email, $from_name);
                $message->attach($file);
            });

        } catch (\Exception $exception) {
            self::myLog($subject . ' : exception');
            self::myLog($exception);
        }
    }
    static function getDeserialize($data){
        $deserializeData=unserialize($data);
        return $deserializeData;
    }

    static function getIdByTable($tableName, $slug)
    {
        $data= DB::table($tableName)->where('slug',$slug)->select('id')->first();
        $id = '';
        if(!empty($data)){
            $id = $data->id;
        }
        return $id;
    }
     static function getCityId($c,$s,$ct){
        $country = Countries::select('id')->where('name',$c)->first();

            if(!empty($country)){
                $state = States::select('id')->where('name',$s)
                    ->where('country_id',$country->id)->first();

            }
            if(!empty($state)){
                $cityState = Cities::select('id','state_id')->where('name',$ct)
                        ->where('state_id',$state->id)->first();

            }
            $cityId='';
            if(!empty($cityState)){
                $cityId = $cityState->id;
                return $cityId;
            }else{
                return $cityId;
            }
    }
    static function getCountryId($c){
        $country = Countries::select('id')->where('name',$c)->first();
        $countryId='';
            if(!empty($country)){
                $countryId = $country->id;
                return $countryId;
            }else{
                return $countryId;
            }
    }
    static function getStateId($s){
        $state = States::select('id')->where('name',$s)->first();
        $stateId='';
            if(!empty($state)){
                $stateId = $state->id;
                return $stateId;
            }else{
                return $stateId;
            }
    }
}
