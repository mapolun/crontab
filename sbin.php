<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sgenmi
 * Date: 18-10-16
 * Time: 下午2:27
 */

define('BASE_PATH', __DIR__);
define("LIB_PATH", BASE_PATH . "/lib");
define("LOG_PATH", BASE_PATH . "/log");
define("CLASS_PATH", BASE_PATH . "/class");
define("CONFIG_FILE", __DIR__."/config.php");

require BASE_PATH . "/autoload.php";
require BASE_PATH . "/function.php";

function help()
{
    $help = <<<EOF
    
php bin.php [class] [action] [params:option]
   class:   
        Foo run  演示执行

    params:
      -t  时间 如:2018-09-15
      -B  开始时间 如:2018-09-15
      -A  结束时间 如:2018-09-30     
         
EOF;
    echo $help, "\n";
    exit;
}

if (!isset($argv[0])
    || !isset($argv[1])
    || !isset($argv[2])

) {
    help();
}

$cls_file = CLASS_PATH.'/'.$argv[1].".php";

if (!is_file($cls_file)) {
    echo $cls_file,"不是文件\n";
    exit;
}

$clsName = $argv[1];
$action = $argv[2];
include $cls_file;

if (strpos($clsName, '/')!==false) {
    $clsName = "\\".str_replace('/', "\\", $clsName);
}

$cls = new $clsName($argv);

if (!method_exists($cls, $action)) {
    echo $cls_file,"没有方法",$action,"\n";
    exit;
}
$cls->$action();
