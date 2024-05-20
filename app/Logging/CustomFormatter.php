<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use App\Common\Config as CommonConfig;
use App\Enums\ErrorLevel;

class CustomFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $log = new GrokLog();
            $formatPattern = $log->getLogFormatPattern();
            $handler->setFormatter(new LineFormatter(
                $formatPattern, 'Y-m-d H:i:s.u'
            ));
        }
    }
}

class GrokLog
{
    var $dateTime,
        $logLevel,
        $errorLevel = ErrorLevel::NONE,
        $serviceId,
        $deviceId,
        $serviceVersion,
        $type,
        $companyId,
        $shopId,
        $resourceId,
        $msg,
        $msgData,
        $msgDetail,
        $ip;

    public function __construct(
    ) {
        $config = new CommonConfig();
        $this->dateTime = '%datetime%';
        $this->logLevel = '%level_name%';
        $this->errorLevel = '%context.errorLevel%';
        $this->serviceId = 'XXX平台 API';
        $this->deviceId = '%context.device_id%';
        $this->serviceVersion = $config::VERSION;
        $this->type = '%context.type%';
        $this->companyId = '%context.company_id%';
        $this->shopId = '%context.shop_id%';
        $this->resourceId = '%context.resourceId%';
        $this->msg = '%message%';
        $this->msgData = '%context.msgData%';
        $this->msgDetail = '%context.msgDetail%';
        $this->ip = $config->getServerIp();
    }

    public function getLogFormatPattern()
    {
        $formatPattern = sprintf(
            '%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s|--|%s%s',
            $this->dateTime,
            $this->ip,
            $this->logLevel,
            $this->errorLevel,
            $this->serviceId,
            $this->deviceId,
            $this->serviceVersion,
            $this->type,
            $this->companyId,
            $this->shopId,
            $this->resourceId,
            $this->msg,
            $this->msgData,
            $this->msgDetail,
            PHP_EOL
        );
        return $formatPattern;
    }
}
