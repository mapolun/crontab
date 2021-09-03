<?php
/**
 * Created by IntelliJ IDEA.
 * Author: sgenmi
 * Date: 2021/7/8 下午2:49
 * Email: 150560159@qq.com
 */
namespace Tools;

class DingTalk
{
    /**
     * 机器人地址
     * @var string
     */
    private $robot_url="";

    /**
     * 机器人密钥
     * @var string
     */
    private $robot_secret='';

    /**
     * 自定义请求客户端
     */
    private $http_client;

    public function __construct(string $robot_url,string $robot_secret)
    {
        $this->robot_url = $robot_url;
        $this->robot_secret = $robot_secret;
    }

    /**
     * 设置请求客户端 支持
     * @param $httpClient
     */
    public function setHttpClient($httpClient){
        $this->http_client = $httpClient;
    }

    /**
     * @param array $mobiles
     * @param string $message
     * @return mixed
     */
    public function send(array $mobiles, string $message ) {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $message
            ],
            'at' => [
                'atMobiles' => $mobiles,
                'isAtAll' => false
            ]
        ];
        return $this->request_dingTalk($data);
    }

    public function sendAll(string $message){
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $message
            ],
            'at' => [
                'isAtAll' => true
            ]
        ];
        return $this->request_dingTalk($data);
    }

    private function request_dingTalk($data){
        $sign = $this->createSign();
        $robot_url =$this->robot_url. ($sign? '&'.http_build_query($sign):'');
        if($this->http_client){
            $res = $this->http_client->post($robot_url, json_encode($data));
        }else{
            $res = $this->post($robot_url, json_encode($data));
        }
        return $res;
    }

    /**
     * 生成sign,如果secret为空，则不生成，直接返回
     * @author Sgenmi
     * @return array
     */
    private function createSign(){
        if(!$this->robot_secret){
            return [];
        }
        $timestamp = (int)(microtime(true)*1000);
        $string_to_sign = $timestamp ."\n".$this->robot_url;
        $sign = urlencode(base64_encode(hash_hmac('sha256', $string_to_sign, $this->robot_secret, true)));
        return [
            'timestamp'=>$timestamp,
            'sign'=>$sign
        ];
    }

    private function post($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json;charset=utf-8'
            ]
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
