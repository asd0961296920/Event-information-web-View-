<?php

namespace App\Logging;

use Monolog\Logger;
use App\Enums\ErrorLevel;
use App\Enums\ResponseType;
use Illuminate\Support\Facades\Log;
use App\Logging\LoggerParams;

class CloudLogger
{

    private array $params;

    private string $apiType;

    private string $resourceID;

    private LoggerParams $logger_params;

    public function __construct(array $params = array(), string $apiType = '', string $resourceID = '', LoggerParams $logger_params = null)
    {
        $this->params = $params;
        $this->apiType = $apiType;
        $this->resourceID = $resourceID;
        $this->logger_params = $logger_params ?? new LoggerParams();
    }

    public function getResourceID(): string
    {
        return $this->resourceID;
    }

    public function setResourceID(string $resourceID): void
    {
        $this->resourceID = $resourceID;
    }

    public function log(string $msg, array $context, int $logType): void
    {
        switch ($logType) {
            case Logger::INFO:
                Log::info($msg, $context);
                break;
            case Logger::WARNING:
                Log::warning($msg, $context);
                break;
            case Logger::ERROR:
                Log::error($msg, $context);
        }
    }

    public function formatLogContext(array $msgData, array $msgDetail, int $errorLevel = ErrorLevel::NONE): array
    {
        $context = $this->params;
        $context['company_id'] = $this->logger_params->getCompanyID();
        $context['device_id'] = $this->logger_params->getDeviceID();
        $context['shop_id'] = $this->logger_params->getShopID();
        $context['errorLevel'] = $errorLevel;
        $context['type'] = $this->apiType;
        $context['resourceId'] = $this->resourceID;
        $context['msgData'] = json_encode($msgData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $context['msgDetail'] = json_encode($msgDetail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $context;
    }

    public function formatResponseMessages(
        int $msgDetailType,
        string $action,
        mixed $data,
        string $errorMessage = '',
        int $statusCode = null
    ): array {
        $actionResult = ($statusCode === 200 or $statusCode === 204 or $statusCode === 201) ? '回應結果' : '失敗';
        $msg = sprintf('%s%s', $action, $actionResult);
        $msgData = array();
        $msgDetail = array();
        switch ($msgDetailType) {
            case ResponseType::GENERAL:
                $msgData = array('action' => $action, 'data' => $data);
                $msgDetail = array(
                    'action_type' => 'response',
                    'action' => $action,
                    'data' => $data,
                    'params' => $this->params
                );
                break;
            case ResponseType::ERROR:
                $msgData = array('action' => $action, 'params' => $this->params);
                $msgDetail = array(
                    'action_type' => 'response',
                    'action' => $action,
                    'message' => $errorMessage,
                    'status_code' => $statusCode,
                    'params' => $this->params
                );
                break;
        }
        return [$msg, $msgData, $msgDetail];
    }

    public function logRequest(string $action, string $url = '', array $headers = array()): void
    {
        $msg = sprintf('請求%s', $action);
        $msgData = array('action' => $action, 'url' => $url);
        $msgDetail = array(
            'action_type' => 'request',
            'action' => $action,
            'url' => $url,
            'headers' => $headers,
            'params' => $this->params,
        );
        $context = $this->formatLogContext($msgData, $msgDetail);
        Log::info($msg, $context);
    }

    public function logResponse(
        string $action,
        int $statusCode,
        mixed $data,
        int $logType = Logger::INFO,
        int $msgDetailType = ResponseType::GENERAL,
        int $errorLevel = ErrorLevel::NONE,
        string $errorMessage = '',
    ): void {
        list($msg, $msgData, $msgDetail) = $this->formatResponseMessages($msgDetailType, $action, $data, $errorMessage, $statusCode);
        $context = $this->formatLogContext($msgData, $msgDetail, $errorLevel);
        $this->log($msg, $context, $logType);
    }
}
