支持 Laravel/Lumen 下控制器注释生成API文档，生成数据库字典, 注册路由呈现

## 安装
    
composer.json 添加, `composer update` 安装.

```php
"require": {
    "wxm/ddoc": "1.0.*@dev"
},
```

## 配置

### Laravel

1. 注册 ServiceProvider (laravel 5.5 不需要注册):
    ```php
    Wxm\DDoc\DDocServiceProvider::class
    ```
    
2. 发布配置：
    ```shell
    php artisan vendor:publish --provider="Wxm\DDoc\DDocServiceProvider" --force
    ```
    
### Lumen

1. 注册 ServiceProvider:
   
    `bootstrap/app.php` 下添加

    ```php
    // 本地环境注册
    if ($app->environment('local')) {
        $app->register(Wxm\DDoc\DDocServiceProvider::class);
    }
    ``` 
2. 手动复制配置文件
    
## 使用

1. 开启服务器:
    ```shell
    php artisan serve
    ```

2. 访问 `http://localhost:8000/ddoc`

## 接口注释 生成文档

```php
/**
 * @Resource("登录令牌", uri="/token")
 */
class AuthController extends Controller
{
    /**
     * 获取令牌
     *
     * > 通过手机号和密码获取会话`token`即登录凭证.
     * > 需要认证的请求请携带此 Authorization 头
     * >
     * > Authorization：Bearer {token}
     * > 
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkueHkudGVzdFwvc2Vzc2lvbiIsImlhdCI6MTU0NTIxNjM5OSwiZXhwIjoxNTQ1MjE5OTk5LCJuYmYiOjE1NDUyMTYzOTksImp0aSI6Im9pZjV4WTNqS2JkbEhzVmQiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.p3oAVkAxSCxTug5s6168N-ccfuCCywGDFiJ0b9zCXq8","token_type":"bearer","expires_in":3600})
     * @Parameters({
     *      @Parameter("phone", type="integer", required=true, description="手机号."),
     *      @Parameter("password", type="string", required=true, description="密码."),
     * })
     */
    public function login()
    {

    }

    /**
     * 销毁当前令牌
     *
     * * 权限要求：`登录用户`
     *
     * > 销毁成功返回 `204` 无内容 Http code
     *
     * @Delete("/")
     * @Versions({"v1"})
     * @Response(204)
     */
    public function logout()
    {

    }

    /**
     * 刷新获取新令牌
     *
     * * 权限要求：`登录用户`
     *
     * > 销毁当前令牌，获取新令牌
     *
     * @Put("/")
     * @Versions({"v1"})
     * @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkueHkudGVzdFwvdG9rZW4iLCJpYXQiOjE1NDUyOTY3MzcsImV4cCI6MTU0NTMwMDM2NywibmJmIjoxNTQ1Mjk2NzY3LCJqdGkiOiI5Rk43TGJxZUlBc1JmZVRwIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.qBCL-EfGYRnlxPZerpHpD9HVumjf89fVa2CBoXoFSvI","token_type":"bearer","expires_in":3600})
     */
    public function refresh()
    {

    }
}
```

参考 [API Blueprint Documentation](https://github.com/dingo/api/wiki/API-Blueprint-Documentation).

## 参考图

![](http://o9o0gmgkr.bkt.clouddn.com/1.png)
![](http://o9o0gmgkr.bkt.clouddn.com/2.png)
![](http://o9o0gmgkr.bkt.clouddn.com/3.png)
![](http://o9o0gmgkr.bkt.clouddn.com/4.png)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.