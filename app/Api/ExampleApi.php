<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Monolog\Logger;

use App\Logging\CloudLogger;
use App\Logging\LoggerParams;
use App\Enums\ErrorLevel;
use App\Enums\ResponseType;

class ExampleApi
{

    private $action;
    private $apiType;
    private $params;
    private $apiURL;
    private LoggerParams $logger_params;

    function __construct(string $action, string $apiType, array $params, string $apiURL, LoggerParams $logger_params)
    {
        $this->action = $action;
        $this->apiType = $apiType;
        $this->params = $params;
        $this->apiURL = $apiURL;
        $this->logger_params = $logger_params;
    }

    public function CallThirdPartyAPI()
    {
        $logger = new CloudLogger($this->params, $this->apiType, '', $this->logger_params);
        $logger->logRequest($this->action, $this->apiURL);
        $response = Http::get($this->apiURL);
        if($response->status() != Response::HTTP_OK){
            $logger->logResponse($this->action, Response::HTTP_BAD_REQUEST, $response->json(), Logger::ERROR,
                ResponseType::GENERAL, ErrorLevel::IMMEDIATE);
            return $response;
        }
        $logger->logResponse($this->action, $response->status(), $response->json());
        return $response;
    }
}
