<?php
namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Services\IslandService;
use DateTime;
class PageController extends Controller
{
    public function home(Request $request,$id)
    {
        // $this->validate($request, [
        //     // 'page' => 'required',
        //     // 'number' => 'required',
        //     'city_id' =>'sometimes',
        //     'keyword' =>'sometimes',
        //     'year' =>'sometimes|integer|nullable',
        //     'moth' =>'sometimes|integer|nullable',
        // ]);

        $IslandService = new IslandService();
        $island = $IslandService->island();
        $js = $IslandService->js();



        $apiDatas = $this->apiDatas($id);



        
        $data = [
            'islands' => $island,
            'title'=> "旅歷台灣",
            'js'=> $js,
            'apiData'=> $apiDatas,
            'url'=>    $IslandService->url(),
         
        ];
        return view('/twgather/PageView', $data);




    }




    public function apiDatas($id)
    {


        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/post/show/" . $id;
        $data = [];



        return $api->get([],$url,$data);

    }



}