<?php

/**
 * Created by IntelliJ IDEA.
 * Author: sgenmi
 * Date: 2021/6/17 下午5:15
 * Email: 150560159@qq.com
 */

function sp_json_to_ck(string $json){
    return urldecode(http_build_query(json_decode($json,true),'',';'));
}

function sp_ck_to_json(string $ck){
    $arr = [];
    if ($ck) {
        $tmpData = array_filter(explode(';',$ck));
        foreach ($tmpData as $item) {
            list($key, $value) = explode('=', trim($item));
            $arr[$key] = $value;
        }
    }
    return json_encode($arr, JSON_UNESCAPED_UNICODE);
}

function sp_write_log($data){
    if (is_array($data)) {
        $data = print_r($data, true);
    }
    $text = date("Y-m-d H:i:s").PHP_EOL;
    $text .= "=====开始=====" .PHP_EOL;
    $text .= $data . PHP_EOL;
    $text .= "=====结束=====" . PHP_EOL;
    $path = LOG_PATH;
    $fileName = date("Ymd");
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
    file_put_contents($path . "/{$fileName}.log", $text, FILE_APPEND);
}

function get_ip(){
    $params=[
        "jsonrpc"=>"2.0",
        "method"=>"/ip_proxy/get",
        "params"=>[5,'075ceefb1ac019e09827f45a04a909e9'],
        "id"=>"1"
    ];
    $ip_api_url = 'http://47.98.212.4:39101';
    $cli = new \Lib\Curl();
    $response = $cli->request($ip_api_url,json_encode($params),'post');
    if (!$response) {
        return [];
    }
    $resArr = json_decode($response,true);
    if($resArr && isset($resArr['result']['code']) && $resArr['result']['code']==0 ){
        return $resArr['result']['data'];
    }
    echo $response .PHP_EOL;
    return [];
}
