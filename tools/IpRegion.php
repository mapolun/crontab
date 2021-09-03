<?php
/**
 * Created by IntelliJ IDEA.
 * Author: sgenmi
 * Date: 2021/8/9 下午8:50
 * Email: 150560159@qq.com
 */
namespace Tools;

use Lib\Curl;

class IpRegion
{
    private $rpcServer='';
    private $result=[];
    public function __construct()
    {
        $this->rpcServer = '172.16.96.189:39100';
    }
    public function getInfo($ip){
        if(!$this->rpcServer){
            return '';
        }
        $cli = new Curl();
        $params=[
            "jsonrpc"=>"2.0",
            "method"=>"/ip2_region/getInfo",
            "params"=>[$ip],
            "id"=>"1"
        ];
        $resJson = $cli->request($this->rpcServer,json_encode($params),'post');
        if(!$resJson){
            return '';
        }
        $resArr = json_decode($resJson,true);
        if($resArr && isset($resArr['result']['code']) && $resArr['result']['code']==0 ){
            $this->result = $resArr['result'];
            return $resArr['result'];
        }
        return '';
    }

    public function getAddr(){
        $region = $this->chunkData();
        if (!$region) {
            return '';
        }
        $addr = '';
        if (!is_numeric($region[0])) {
            $addr .= $region[0];
        }
        if (!is_numeric($region[2])) {
            $addr .= '/' . $region[2];
        }
        if (!is_numeric($region[3])) {
            $addr .= '/' . $region[3];
        }
        return $addr;
    }

    public function getCountry()
    {
        $region = $this->chunkData();
        if (!$region || is_numeric($region[0])) {
            return '';
        }
        return $region[0];
    }

    public function getProvince()
    {
        $region = $this->chunkData();
        if (!$region || is_numeric($region[2])) {
            return '';
        }
        return $region[2];
    }

    public function getCity()
    {
        $region = $this->chunkData();
        if (!$region || is_numeric($region[3])) {
            return '';
        }
        return $region[3];
    }

    private function chunkData()
    {
        if (!$this->result) {
            return '';
        }
        $region = explode('|',($this->result['data']['region']??''));
        if (!$region && !is_array($region) && count($region) < 1) {
            return '';
        }
        if (is_numeric($region[0])) {
            return "";
        }
        return $region;
    }
}
