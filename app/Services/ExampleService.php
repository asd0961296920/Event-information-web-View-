<?php
namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Monolog\Logger;

use App\Logging\CloudLogger;
use App\Enums\ErrorLevel;
use App\Enums\ResponseType;
use App\Logging\LoggerParams;
use App\Api\ExampleApi;


class ExampleService
{
    private string $action;
    private string $apiType;
    private array $params;
    private LoggerParams $logger_params;

    public function __construct(string $action, string $apiType, LoggerParams $logger_params, array $params = array())
    {
        $this->action = $action;
        $this->apiType = $apiType;
        $this->params = $params;
        $this->logger_params = $logger_params;
    }

    public function GetData(Request $request, string $id): JsonResponse
    {
        $logger = new CloudLogger($this->params, $this->apiType, '', $this->logger_params);
        $logger->logRequest($this->action, $request->fullUrl());
        try {
            $api_url = 'https://jsonplaceholder.typicode.com/todos/' . $id;
            $api = new ExampleApi('第三方平台取得資料 API', $this->apiType, [], $api_url, $this->logger_params);
            $response = $api->CallThirdPartyAPI();
            if($response->status() != Response::HTTP_OK) {
                $logger->logResponse($this->action, Response::HTTP_BAD_REQUEST, $response->json(), Logger::ERROR,
                    ResponseType::GENERAL, ErrorLevel::IMMEDIATE);
                return response()->json($response->json(), $response->status());
            }
            $logger->logResponse($this->action, $response->status(), $response->json());
            return response()->json($response->json(), $response->status());
        } catch (Exception $e) {
            $logger->logResponse($this->action, Response::HTTP_BAD_REQUEST, [], Logger::ERROR,
                ResponseType::ERROR, ErrorLevel::IMMEDIATE, $e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
