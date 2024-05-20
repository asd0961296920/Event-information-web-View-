<?php

namespace App\Common;

class Config
{
    public const VERSION = '0.0.0.1';
    private $serverHost;

    public function __construct()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $this->serverHost = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], ':'));
        } else if (isset($_SERVER['SERVER_NAME'])) {
            $this->serverHost = $_SERVER['SERVER_NAME'];
        } else {
            $this->serverHost = '127.0.0.1';
        }
    }

    public function getServerIP()
    {
        return gethostbyname($this->serverHost);
    }
}
