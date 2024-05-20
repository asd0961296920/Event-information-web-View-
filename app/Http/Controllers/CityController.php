<?php
namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Services\IslandService;
use DateTime;
class CityController extends Controller
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


        $yearsArray = $IslandService->yearsArray();
        $year=null;
        $moth=null;
        $page=null;
        $keyword=null;
        if($request->input("year") !=  "null"){
            $year = $request->input("year");
        }
        if($request->input("moth") !=  "null"){
            $moth = $request->input("moth");
        }
        if($request->input("page") !=  "null"){
            $page = $request->input("page");
        }
        if($request->input("keyword") !=  "null"){
            $keyword = $request->input("keyword");
        }

        $apiDatas = $this->apiDatas($year,$moth,$page,$keyword,$id);



        
        $data = [
            'islands' => $island,
            'title'=> "旅歷台灣",
            'js'=> $js,
            'yearsArray'=> $yearsArray,
            'apiDatas'=> $apiDatas,
            'year'=>$year,
            'moth'=>$moth,
            'city'=>$this->city($id,$island),       
            'url'=>    $IslandService->url(),
        ];
        return view('/twgather/CityView', $data);




    }


    public function city($id,$islands)
    {

        foreach ($islands as $island) {
            if($island->id == $id){
                return $island->city;
            }

        }

    }


    public function apiDatas($year=null,$moth=null,$page=1,$keyword=null,$id)
    {
        if($page == null){
            $page = 1;
        }

        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/post/list";
        $data = ['page'=> $page,'number'=>10,"year"=>$year,"moth"=>$moth,"city_id"=>$id];
        if($keyword != null){
            $data["keyword"] = $keyword;
        }


        return $api->get([],$url,$data);

    }



}