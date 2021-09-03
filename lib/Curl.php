<?php
namespace Lib;

class  Curl
{
    private $curl_ua = "okhttp/3.10.0.1";
    private $curl_header = [];
    private $curl_referer = '';
    private $curl_cookie = '';
    private $proxy_ip = '';
    private $proxy_port = 0;
    private $timeout = 6;

    private $curl_token="";

    /**
     * @param string $curl_ua
     */
    public function setCurlUa($curl_ua = '')
    {
        $this->curl_ua = $curl_ua;
    }

    public function getCurlUa(){
        return $this->curl_ua;
    }

    /**
     * @param array $curl_header
     */
    public function setCurlHeader($curl_header = [])
    {
        $this->curl_header = $curl_header;
    }

    /**
     * @param string $curl_referer
     */
    public function setCurlReferer($curl_referer = '')
    {
        $this->curl_referer = $curl_referer;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param string $curl_cookie
     */
    public function setCurlCookie($curl_cookie = '')
    {
        $this->curl_cookie = $curl_cookie;
    }

    public function getCurlCookie()
    {
        return $this->curl_cookie;
    }

    public function request($url, $keysArr = [], $mothod = 'get', $return_header = false, $flag = 0)
    {

        $ch = curl_init();
        if (!$flag) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (strtolower($mothod) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);

            if(!empty($keysArr)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
            }

        } elseif (strtolower($mothod) == 'put') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);//设置提交的字符串
        } elseif (strtolower($mothod) == 'options') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"OPTIONS");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);//设置提交的字符串
        } else {
            if(strpos($url,'?')!==false){
                if($keysArr){
                    $url = $url . "&" . http_build_query($keysArr);
                }
            }else{
                if($keysArr){
                    $url = $url . "?" . http_build_query($keysArr);
                }
            }
        }

        if ($this->curl_cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->curl_cookie);
        }
        if ($return_header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if ($this->curl_ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->curl_ua);
        }
        if ($this->curl_referer) {
            curl_setopt($ch, CURLOPT_REFERER, $this->curl_referer);
        }
        if ($this->proxy_ip && $this->proxy_port) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
        }
        if ($this->curl_header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->curl_header);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $ret = curl_exec($ch);
        if ($return_header) {
            if ($this->proxy_ip && $this->proxy_port) {
                if (strpos($ret, 'Connection established') !== false) {
                    list($proxy_header, $header, $content) = explode("\r\n\r\n", $ret);
                    $ret = ['header' => $header, 'data' => $content];
                } else {
                    if ($ret) {
                        list($header, $content) = explode("\r\n\r\n", $ret);
                        $ret = ['header' => $header, 'data' => $content];
                    }
                }
            } else {
                list($header, $content) = explode("\r\n\r\n", $ret);
                $ret = ['header' => $header, 'data' => $content];
            }
        }
        $err = curl_error($ch);
        curl_close($ch);
        return $ret;
    }

    /**
     * @param int $proxy_port
     * @return Curl
     */
    public function setProxyPort($proxy_port)
    {
        $this->proxy_port = $proxy_port;
    }

    /**
     * @param string $proxy_ip
     * @return Curl
     */
    public function setProxyIp($proxy_ip)
    {
        $this->proxy_ip = $proxy_ip;
    }

    /**
     * @param string $curl_token
     */
    public function setCurlToken($curl_token)
    {
        $this->curl_token = $curl_token;
    }

    /**
     * @return string
     */
    public function getCurlToken()
    {
        return $this->curl_token;
    }
}
