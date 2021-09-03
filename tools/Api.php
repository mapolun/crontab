<?php
/**
 * @Author mapo
 * @Date   2021/6/17
 */
namespace Tools;

class Api
{

    /**
     * misc_datacubequery_url
     * @var string
     */
    public static $misc_datacubequery_url = 'https://mp.weixin.qq.com/misc/datacubequery';

    /**
     * misc_datacubequery_header
     * @var string
     */
    public static $misc_datacubequery_header = [
        'origin' => 'https://mp.weixin.qq.com',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36',
        'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    ];

    /**
     * 转发数据集
     * Author 麻破伦意识
     * Date 2019/9/5
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $data = self::$$name;
        if (empty($arguments)) return $data;
        $type = $arguments[0] ?? "url";
        $arguments = $arguments[1] ?? [];
        if ($type == "url") {
            return sprintf($data, ...$arguments);
        } else {
            array_walk($arguments, function($io, $item) use (&$data){
                $data[$item] = $io;
            });
            return $data;
        }
    }

    /**
     * 重组cookie
     * Author 麻破伦意识
     * Date 2019/9/2
     * @param array $arr
     * @return array
     */
    public static function packCookie(array $arr) : array
    {
        $cookie = [];
        foreach ($arr as $k => $v) {
            $tmp_str = explode('=', explode(';', $v)[0]);
            $cookie[trim($tmp_str[0])] = trim($tmp_str[1]);
        }
        return $cookie;
    }
}