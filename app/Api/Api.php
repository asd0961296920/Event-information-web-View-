<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;
use App\Logging\CloudLogger;
use App\Logging\LoggerParams;
use Monolog\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class Api
{

    /**
     * 回傳前經過判斷
     *
     */
    public function return(mixed $data, int $state, string $action, string $apiType, array $input)
    {
        if ($state != 200) {
            $this->log_response($data, $apiType, $state, $action, $input);
            if (is_object($data)) {
                $response = response()->json($data)->setStatusCode($state);
                $response->send();
                exit;
            }
            $response = response()->json($data)->setStatusCode($state);
            $response->send();
            exit;
        }
        return $data;
    }

    /**
     * 紀錄log(request)
     *
     */
    public function log_request(mixed $data, string $apiType, string $url, array $header, string $action)
    {
        $loggerParams = new LoggerParams();
        $logger = new CloudLogger($data, $apiType, '', $loggerParams);
        $logger->logRequest($action, $url,  $header);
    }


    /**
     * 紀錄log(response)
     *
     */
    public function log_response(mixed $data, string $apiType, int $status, string $action, array $resquest)
    {
        if ($status != 200) {
            $loggerParams = new LoggerParams();
            $logger = new CloudLogger($resquest, $apiType, '', $loggerParams);
            $logger->logResponse($action, $status, $data, Logger::ERROR);
        } else {
            $loggerParams = new LoggerParams();
            $logger = new CloudLogger($resquest, $apiType, '', $loggerParams);
            $logger->logResponse($action, $status, $data);
        }
    }


    /**
     * 驗證連接是否正確（ＧＥＴ）
     *
     */
    public function token(array $headers, string $apiUrl)
    {
        try {
            $response = Http::withHeaders($headers)
                ->get($apiUrl);
            if ($response->status() === 200) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            // 捕获并处理任何异常
            throw $e;
        }
    }

    /**
     * 帶標頭的GET連接
     *
     */
    public function get(array $header, string $apiUrl, array $input)
    {
        $response = Http::withHeaders($header)
        ->get($apiUrl, $input);
        if ($response->status() === 200) {
            return json_decode($response);
        }

    }

    /**
     * 帶標頭的POST連接
     *
     */
    public function post(array $header, string $apiUrl, array $input, string $action, string $apiType)
    {
        for ($i = 0; $i < 4; $i++) {
            $this->log_request($input, $apiType, $apiUrl, $header, $action);
            $response = Http::withHeaders($header)
                ->post($apiUrl, $input);
            $this->log_response($response->json(), $apiType, $response->status(), $action, $input);
            if ($response->status() === 200) {
                return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
            }
        }
        return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
    }


    /**
     * 帶標頭的PUT連接
     *
     */
    public function put(array $header, string $apiUrl, array $input, string $action, string $apiType)
    {
        for ($i = 0; $i < 4; $i++) {
            $this->log_request($input, $apiType, $apiUrl, $header, $action);
            $response = Http::withHeaders($header)
                ->put($apiUrl, $input);
            $this->log_response($response->json(), $apiType, $response->status(), $action, $input);
            if ($response->status() === 200) {
                return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
            }
        }
        return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
    }


    /**
     * 帶標頭的PATCH連接
     *
     */
    public function patch(array $header, string $apiUrl, array $input, string $action, string $apiType)
    {
        for ($i = 0; $i < 4; $i++) {
            $this->log_request($input, $apiType, $apiUrl, $header, $action);
            $response = Http::withHeaders($header)
                ->patch($apiUrl, $input);
            $this->log_response($response->json(), $apiType, $response->status(), $action, $input);
            if ($response->status() === 200) {
                return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
            }
        }
        return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
    }

    /**
     * 帶標頭的DELETE連接
     *
     */
    public function delete(array $header, string $apiUrl, array $input, string $action, string $apiType)
    {
        for ($i = 0; $i < 4; $i++) {
            $this->log_request($input, $apiType, $apiUrl, $header, $action);
            $response = Http::withHeaders($header)
                ->delete($apiUrl, $input);
            $this->log_response($response->json(), $apiType, $response->status(), $action, $input);
            if ($response->status() === 200) {
                return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
            }
        }
        return $this->return(json_decode($response), $response->status(), $action, $apiType, $input);
    }

    public function error(mixed $error)
    {
        return response()->json(['success' => false, 'errors' => $error]);
    }

    //標準時區（+0）轉台灣時區（+8）
    public function time_UCT_in_TW(string $date)
    {
        // 創建 DateTime 物件，並指定原始時間和 UTC 時區
        $dateTimeUtc = new \DateTime($date, new \DateTimeZone('UTC'));

        // 將時區設定為 UTC+8
        $dateTimeUtc->setTimezone(new \DateTimeZone('Asia/Taipei'));

        // 取得轉換後的時間
        $dateTimeTaipei = $dateTimeUtc->format('Y-m-d H:i:s');
        return $dateTimeTaipei;
    }

    /**
     * 驗證request
     *
     */
    public function validator(Request $data, $class, string $apiType, string $action)
    {
        $validator = Validator::make($data->all(), $class->rules());

        if ($validator->fails()) {
            $this->log_response($validator->errors()->all(), $apiType, 400, $action, $data->all());
            http_response_code(400);
            $response = $this->error($validator->errors()->all());
            $response->send();
            exit;
        }
        return true;
    }



    /**
     * 日期中是否含有時分秒
     *
     */
    public function hasTime($dateString)
    {
        // 嘗試以特定格式解析日期時間
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateString);

        // 如果解析成功，表示包含時分秒
        // 如果解析失敗，表示不包含時分秒
        return $dateTime !== false;
    }


    // /**
    //  * 獲取網頁原始碼
    //  *
    //  */
    // public function getWebpage(string $url)
    // {

    //     $user = User::first();
    //     if($user->chrome){
    //         return $this->getWebpage_chrome($url);
    //     }

    //     // 使用 cURL 初始化一个新的会话
    //     $curl = curl_init();

    //     // 设置 cURL 选项
    //     curl_setopt($curl, CURLOPT_URL, $url); // 设置 URL
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 将返回的内容作为字符串返回而不是直接输出
    //     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // 允许 cURL 自动跟踪重定向
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 忽略 SSL 证书验证

    //     // 执行 cURL 请求并获取返回的页面内容
    //     $html = curl_exec($curl);

    //     // 检查是否发生错误
    //     if ($html === false) {
    //         return "Error fetching webpage: " . curl_error($curl);
    //         return false;
    //     }

    //     // 关闭 cURL 会话
    //     curl_close($curl);

    //     return $html;
    // }

    //  /**
    //  * 獲取網頁原始碼
    //  *
    //  */
    // public function getWebpage_chrome(string $url)
    // {
    //    // 要请求的 Node.js 服务器的地址
    //    $nodeJSUrl = 'https://node.loca.lt/chrome';

    //    // 要获取的网页的 URL
    //    $urlToFetch = $url;

    //    // 创建 Guzzle 客户端
    //    $client = new Client();

    //    try {
    //        // 发送 GET 请求到 Node.js 服务器，并传递网页的 URL 作为参数
    //        $response = $client->request('GET', $nodeJSUrl, [
    //            'query' => ['url' => $urlToFetch]
    //        ]);

    //        // 检查响应状态码
    //        if ($response->getStatusCode() === 200) {
    //            // 返回页面内容
    //            return strval($response->getBody()->getContents());
    //        } else {
    //            return "Failed to load page. Status code: " . $response->getStatusCode();
    //        }
    //    } catch (\Exception $e) {
    //        // 捕获异常并返回错误消息
    //        return "Failed to load page. Exception: " . $e->getMessage();
    //    }
    // }
}
