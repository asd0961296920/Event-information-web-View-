<?php

namespace App\Console\Commands;

use Illuminate\Http\Response;
use Illuminate\Console\Command;
use App\Logging\CloudLogger;

class LogClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日清除Log';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = '每日清除Log';
        $logger = new CloudLogger();
        $logger->logRequest($action);

        $file_path = 'logs/omniplatformapiforpos.log';
        $log = storage_path($file_path);
        if (file_exists($log)) {
            $old_content = file_get_contents($log);
            $now_content = file_get_contents($log);
            $new_content = str_replace($old_content, '', $now_content);
            file_put_contents($log, $new_content);
            $logger->logResponse($action, Response::HTTP_NO_CONTENT, ["message" => $action . "成功"]);
        } else {
            $logger->logResponse($action, Response::HTTP_NO_CONTENT, ["message" => $file_path . "檔案不存在"]);
        }
    }
}
