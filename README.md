# crontab
##### 轻量的定时任务骨架，遵循psr-4规范

* EasySwoole
* PHP >= 7.0

## 1.创建脚本   
在class目录下创建Foo.php，每个脚本继承Base类
```php
class Foo extends Base
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function run()
    {
        $this->echoLog("执行开始");
        //业务逻辑...
        
        $this->echoLog("执行结束");
    }
}
```
## 2.运行

```php
php sbin.php Foo run
```


