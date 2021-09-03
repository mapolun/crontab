<?php
/**
 * Author mapo
 * Date   2021/9/3
 */
namespace Service;

use Tools\IpProxy;

class FooService
{
    /**
     * @return IpProxy
     * Author mapo
     * Date   2021/9/3
     */
    public function getIpProxy()
    {
        return new IpProxy();
    }
}