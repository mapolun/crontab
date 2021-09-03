<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sgenmi
 * Date: 18-9-18
 * Time: 下午2:40
 */

use Lib\Env;

return [
        'redis.app' => [
            'host' => Env::get('redis.app.host', '192.168.2.222'),
            'port' => Env::get('redis.app.port', 6380),
            'auth' => Env::get('redis.app.auth', '')
        ],
        'redis.put' => [//微信前台
            'host' => Env::get('redis.put.host', '192.168.2.222'),
            'port' => Env::get('redis.put.port', 6381),
            'auth' => Env::get('redis.put.auth', '')
        ],
        'db.app' => [
            'database_type' => Env::get('db.app.database_type', 'mysql'),
            'database_name' => Env::get('db.app.database_name', 'xmt'),
            'server' => Env::get('db.app.host', '192.168.2.222'),
            'username' =>Env::get('db.app.username', 'root'),
            'password' =>Env::get('db.app.password', 'Ezsv9499'),
            'charset' => Env::get('db.app.charset', 'utf8'),
            'port' => Env::get('db.app.port', 3306),
            'prefix' => Env::get('db.app.prefix', '')
        ],
        'app' => [
            'status' => Env::get('app.status', 'dev'),  // 开发环境 dev || prod
        ]

];
