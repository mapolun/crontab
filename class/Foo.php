<?php
/**
 * Author mapo
 * Date   2021/9/3
 */

use Lib\Base;
use Lib\Log;
use Service\FooService;

class Foo extends Base
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function run()
    {
        $ck = "Hm_lvt_f0b17751385cbe9cea2ad4d45e3176cd=1626743699; code=270630; Hm_lvt_dde6ba2851f3db0ddc415ce0f895822e=1628251058; PHPSESSID=a8n6r3soaqou5q4op2tdl6upfm; SERVERID=b2c0abd46df7def25ea4c18e3f6247f2|1630291111|1630291110; menu1=5; menu2=247; Hm_lpvt_dde6ba2851f3db0ddc415ce0f895822e=1630322360";
        var_dump(fn_json_to_ck(fn_ck_to_json($ck)));
//        $this->echoLog("执行开始");
        //业务逻辑
//        var_dump((new FooService())->getIpProxy()->get());
//        Log::info(123,'test',false);
//        $this->echoLog("执行结束");
    }
}