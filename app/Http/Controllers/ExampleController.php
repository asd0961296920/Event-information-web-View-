<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExampleService;

class ExampleController extends Controller
{
    public function GetData(Request $request, string $id)
    {
        $action = "取得資料";
        $apiType = "example-get_data";
        $service = new ExampleService($action, $apiType, $this->logger_params, $this->params);
        $response = $service->GetData($request, $id);
        return $response;
    }
}