<?php
namespace App\Services;


use App\Api\Api;

use DateTime;
class IslandService
{



    public function island()
    {

        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/area/list";
        return $api->get([],$url,[]);

    }



    public function js()
    {

        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/post/js";
        return $api->get([],$url,[]);

    }



    public function yearsArray()
    {
    $now = new DateTime();
    $year = $now->format('Y');
    $yearsArray = [
      $year + 1,
      $year + 0,
      $year - 1,
      $year - 2,
      $year - 3
    ];
    return $yearsArray;
    }


    public function url()
    {

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        
        $fullUrl = $protocol . "://" . $host . $uri;
        
        return $fullUrl;
    }

}
