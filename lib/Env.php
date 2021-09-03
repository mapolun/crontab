<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sgenmi
 * Date: 18-12-24
 * Time: 上午9:35
 */
namespace Lib;

class Env
{
    private static $envConfig=[];

    public static function get($key, $dafault_value="")
    {
        self::getEnvFile();
        if(isset(self::$envConfig[$key])){
            return self::$envConfig[$key];
        }else{
            return $dafault_value;
        }
    }

    private static function getEnvFile(){

        if(self::$envConfig){
            return self::$envConfig;
        }

        $envFile = BASE_PATH."/.env";
        if(!is_file($envFile)){
            return true;
        }
        $envArr = parse_ini_file($envFile);
        self::$envConfig = $envArr;
    }

    public static function getArrVal($arr,$key){

        $ret = "";
        if(!$arr || !$key || !is_array($arr)){
            return $ret;
        }

        if(isset($arr[$key])){
            $ret = $arr[$key];
        }
        return $ret;
    }
}