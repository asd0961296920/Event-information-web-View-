<?php

namespace App\Logging;

class LoggerParams
{

    private string $company_id;

    private string $shop_id;

    private string $device_id;


    public function __construct(string $company_id = '', string $shop_id = '', string $device_id = '')
    {
        $this->company_id = $company_id;
        $this->shop_id = $shop_id;
        $this->device_id = $device_id;
    }

    public function getCompanyID(): string
    {
        return $this->company_id;
    }

    public function getShopID(): string
    {
        return $this->shop_id;
    }

    public function getDeviceID(): string
    {
        return $this->device_id;
    }
}
