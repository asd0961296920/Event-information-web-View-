<?php
namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Services\IslandService;
use DateTime;
use Illuminate\Support\Facades\Response;
class HomeController extends Controller
{
    public function home(Request $request)
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

        $apiDatas = $this->apiDatas($year,$moth,$page,$keyword);



        
        $data = [
            'islands' => $island,
            'title'=> "旅歷台灣",
            'js'=> $js,
            'yearsArray'=> $yearsArray,
            'apiDatas'=> $apiDatas,
            'year'=>$year,
            'moth'=>$moth,            
        ];
        return view('/twgather/HomeView', $data);




    }




    public function apiDatas($year=null,$moth=null,$page=1,$keyword=null)
    {
        if($page == null){
            $page = 1;
        }

        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/post/list";
        $data = ['page'=> $page,'number'=>10,"year"=>$year,"moth"=>$moth];
        if($keyword != null){
            $data["keyword"] = $keyword;
        }


        return $api->get([],$url,$data);

    }


    public function image()
    {
        $path = public_path('cc.jpg');

        // 檢查圖片是否存在
        if (!file_exists($path)) {
            abort(404);
        }

        // 取得圖片內容
        $file = file_get_contents($path);

        // 建立響應並返回圖片內容
        return Response::make($file, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="example.jpg"',
        ]);
    }

}