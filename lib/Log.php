<?php

/**
 * Created by IntelliJ IDEA.
 * Author: sgenmi
 * Date: 2020/6/4 下午6:13
 * Email: 150560159@qq.com
 */
namespace Lib;

class Log
{
    static function info($content,$name="", $is_write=true, $category = 'DEBUG'){
        if(!is_string($content)){
            $content = json_encode($content,JSON_UNESCAPED_UNICODE);
        }
        if($name){
            $content = $name." : ".$content;
        }
        Logger::getInstance()->info($content,$category,$is_write);//记录info级别日志并输出到控制台
    }

    static function notice($content,$name="",$is_write=true,$category = 'DEBUG'){

        if(!is_string($content)){
            $content = json_encode($content,JSON_UNESCAPED_UNICODE);
        }
        if($name){
            $content = $name." : ".$content;
        }
        Logger::getInstance()->notice($content,$category,$is_write);//记录notice级别日志并输出到控制台
    }

    static function waring($content,$name="",$is_write=true,$category = 'DEBUG'){

        if(!is_string($content)){
            $content = json_encode($content,JSON_UNESCAPED_UNICODE);
        }
        if($name){
            $content = $name." : ".$content;
        }
        Logger::getInstance()->waring($content,$category,$is_write);//记录waring级别日志并输出到控制台

    }
    static function error($content,$name="",$is_write=true,$category = 'DEBUG'){

        if(!is_string($content)){
            $content = json_encode($content,JSON_UNESCAPED_UNICODE);
        }
        if($name){
            $content = $name." : ".$content;
        }
        Logger::getInstance()->error($content,$category,$is_write);//记录error级别日志并输出到控制台
    }
}


// Looger 类，来自easySwoole 具体请见easySwoole源码

class Logger  {

    const LOG_LEVEL_INFO = 1;
    const LOG_LEVEL_NOTICE = 2;
    const LOG_LEVEL_WARNING = 3;
    const LOG_LEVEL_ERROR = 4;
    private $logDir;

    function __construct(string $logDir = null)
    {
        if(empty($logDir)){
            $logDir = LOG_PATH;
        }
        if(defined('LOG_PATH')){
            $logDir = LOG_PATH;
        }
        $this->logDir = $logDir;
    }

    function console(?string $msg,int $logLevel = self::LOG_LEVEL_INFO,string $category = 'DEBUG',bool $is_write=true)
    {
        $date = date('Y-m-d H:i:s');
        $levelStr = $this->levelMap($logLevel);
        $str =  $this->colorString("[{$date}][{$category}][{$levelStr}] : [{$msg}]",$logLevel)."\n";
        if($is_write){
            $fileName = date("Ymd");
            if(!file_exists($this->logDir)){
                mkdir($this->logDir, 0777, true);
            }
            $filePath = $this->logDir."/{$fileName}.log";
            file_put_contents($filePath,"{$str}",FILE_APPEND|LOCK_EX);
        }else{
            echo $str;
        }
        return $str;
    }

    private static $instance;

    static function getInstance(...$args)
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }

    private function colorString(string $str,int $logLevel)
    {
        switch($logLevel) {
            case self::LOG_LEVEL_INFO:
                $out = "[42m";
                break;
            case self::LOG_LEVEL_NOTICE:
                $out = "[43m";
                break;
            case self::LOG_LEVEL_WARNING:
                $out = "[45m";
                break;
            case self::LOG_LEVEL_ERROR:
                $out = "[41m";
                break;
        }
        return chr(27) . "$out" . "{$str}" . chr(27) . "[0m";
    }

    private function levelMap(int $level)
    {
        switch ($level)
        {
            case self::LOG_LEVEL_INFO:
                return 'INFO';
            case self::LOG_LEVEL_NOTICE:
                return 'NOTICE';
            case self::LOG_LEVEL_WARNING:
                return 'WARNING';
            case self::LOG_LEVEL_ERROR:
                return 'ERROR';
            default:
                return 'UNKNOWN';
        }
    }

    public function info(?string $msg,string $category = 'DEBUG',bool $is_write=true)
    {
        $this->console($msg,self::LOG_LEVEL_INFO,$category,$is_write);
    }

    public function notice(?string $msg,string $category = 'DEBUG',bool $is_write=true)
    {
        $this->console($msg,self::LOG_LEVEL_NOTICE,$category,$is_write);
    }

    public function waring(?string $msg,string $category = 'DEBUG',bool $is_write=true)
    {
        $this->console($msg,self::LOG_LEVEL_WARNING,$category,$is_write);
    }

    public function error(?string $msg,string $category = 'DEBUG',bool $is_write=true)
    {
        $this->console($msg,self::LOG_LEVEL_ERROR,$category,$is_write);
    }
}