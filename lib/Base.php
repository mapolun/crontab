<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sgenmi
 * Date: 18-10-16
 * Time: 下午2:29
 */
namespace Lib;

class Base
{
    protected $db;
    protected $config;
    protected $params = [];

    public function __construct($params = [])
    {
        if (!is_file(CONFIG_FILE)) {
            echo CONFIG_FILE, "不是文件\n";
            exit;
        }
        $this->config = require CONFIG_FILE;
        $this->db = new Medoo($this->config['db.app']);
        $this->setParams($params);
    }

    private function setParams($params = [])
    {
        if (!$params) {
            return;
        }

        $ret = [];
        $_ret = [];
        foreach ($params as $k => $v) {
            if (strpos($v, "-") === 0) {
                $_v = str_replace("-", "", $v);
                //一定是一个字符
                if (strlen($_v) == 1) {
                    //大小写范围
                    $_v_ac = ord(trim($_v));
                    if (($_v_ac >= ord("a") && $_v_ac <= ord('z'))
                        || ($_v_ac >= ord("A") && $_v_ac <= ord('Z'))
                    ) {
                        $ret[$k][$_v] = "";
                    }
                }
            } else {
                $_k = $k - 1;
                if (isset($ret[$_k])) {
                    //把上一个参数赋值
                    foreach ($ret[$_k] as $rk => $rv) {
                        $_ret[$rk] = $v;
                    }
                }
            }
        }
        $this->params = $_ret;
    }

    protected function getRedis($type = 'redis.app')
    {
        $redis = new \Redis();
        $_redis_config = $this->config[$type];

        $redis->connect($_redis_config["host"], $_redis_config["port"]);
        if (isset($_redis_config["auth"]) && $_redis_config["auth"]) {
            $redis->auth($_redis_config["auth"]);
        }
        return $redis;
    }

    protected function getMedoo($type = 'db.app'){
        if(!isset($this->config[$type])){
            $this->echoLog($type.'');
            return null;
        }
        return new Medoo($this->config[$type]);
    }

    public function echoLog($msg=''){
        echo date('Y-m-d H:i:s').'=>'.$msg."\n";
        return true;
    }
}
