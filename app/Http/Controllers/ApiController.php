<?php

namespace App\Http\Controllers;
 
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Lang;

class ApiController extends BaseController {
    /*
     * For json response comman jsonResponse
     * @param $getArray
     * @return Json 
     */

    const STATUS200 = 200;

    public function jsonResponse($getArray = array()) {
        if (is_array($getArray) && !empty($getArray)) {
            return Response::json($getArray)
                            ->setStatusCode(200, 'The resource is created successfully!')
                            ->header('Content-Type', 'application/json');
        } else {
            return Response::json(["status" => false, "msg" => "Oops", 'error_log' => "Invalid Json or array is blank"]);
        }
    }

    /**
     * check your string is a valid isValidJson
     * @return 	
     * @param	$string
     */
    public function isValidJson($string) {
        $decoded = json_decode($string);
        if (!is_object($decoded) && !is_array($decoded)) {
            return false;
        }
        return (json_last_error() == JSON_ERROR_NONE);
    }

}
