基于 laravel 框架, 读取数据库信息生成数据库字典, 通过控制器注释生成API接口文档, 注册 ddoc 路由网页形式呈现

> 1. 前端呈现使用的 [docute](https://docute.js.org).
> 2. API 注释生成采用的 [dingo/blueprint](https://github.com/dingo/blueprint).
> 3. 参考了 [jormin/laravel-ddoc](https://github.com/jormin/laravel-ddoc).

## 安装
    
直接从 composer.json 添加, 执行 `composer update` 安装.

```php
"require": {
    "wxm/ddoc": "1.0.*@dev"
},
```

或者 composer require 安装. 某些环境原因会导致这种方式安装失败.  
    
```bash
composer require wxm/ddoc:1.0.x@dev 
```

## 配置

1. 注册 ServiceProvider:
    ```php
    Wxm\DDoc\DDocServiceProvider::class
    ```
    
2. 创建配置文件：
    ```shell
    php artisan vendor:publish
    ```
	
	执行命令后会在 `config` 目录下生成配置文件, 在 `public/vendor` 下生成资源文件。
	
## 使用

访问 `[http|https]://[your domain or ip]/ddoc`

默认开启验证, 验证密码 `root`

## 接口注释 生成文档

参考 [API Blueprint Documentation](https://github.com/dingo/api/wiki/API-Blueprint-Documentation).

## 参考图

![](http://o9o0gmgkr.bkt.clouddn.com/1.png)
![](http://o9o0gmgkr.bkt.clouddn.com/2.png)
![](http://o9o0gmgkr.bkt.clouddn.com/3.png)
![](http://o9o0gmgkr.bkt.clouddn.com/4.png)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.