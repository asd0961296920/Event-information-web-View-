<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Api\Api;
class SitemapController extends Controller
{
    public function index()
    {
        // 获取需要放入 sitemap 的 URL
        $url = "https://panel.twgather.techscomet.com";
        $urls = [
            'https://panel.twgather.techscomet.com/',
            // 添加更多的 URL 到这里
        ];

        for ( $i = 1; $i <= 22; $i++) {
            $urls[] =$url . "/city/" . $i;
        }
        
        foreach ($this->apiDatas() as $text) {
            $urls[] = $url . "/page/" . $text->id;
        }







        // 生成 sitemap.xml 内容
        $xml = $this->generateXml($urls);

        // 返回 XML 响应
        return Response::make($xml, '200')->header('Content-Type', 'text/xml');
    }

    private function generateXml($urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . $url . '</loc>';
            $xml .= '<lastmod>' . date('c', strtotime('now')) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
    public function apiDatas()
    {


        $api = new Api();
        $url = env("ADMIN_URL") . "/v1/post/all";
        $data = [];



        return $api->get([],$url,$data);

    }
}
