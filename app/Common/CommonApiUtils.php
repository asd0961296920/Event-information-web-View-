<?php

namespace App\Common;

use App\Logging\LoggerParams;
use Illuminate\Http\Request;

class CommonApiUtils
{
    public static function getLoggerParams(Request $request = null): LoggerParams
    {
        if(is_null($request))
        {
            return new LoggerParams();
        }
        $company_id = $request->input('company_id', '');
        $shop_id = $request->input('shop_id', '');
        $device_id = $request->input('device_id', '');
        return new LoggerParams($company_id, $shop_id, $device_id);
    }
}
