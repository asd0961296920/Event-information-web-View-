<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Common\Config as CommonConfig;
use App\Common\CommonApiUtils;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="OpenAPI",
 *     description="<h1>This is description</h1>"
 * ),
 * @OA\Server(url="", description="測試環境"),
 * @OA\Server(url="http://127.0.0.1:8000", description="本機環境"),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    var $params,
        $logger_params;

    public function __construct(Request $request)
    {
        $this->params = $request->json()->all();
        $this->logger_params = CommonApiUtils::getLoggerParams($request);
    }

    public function GetVersion()
    {
        return CommonConfig::VERSION;
    }
}
