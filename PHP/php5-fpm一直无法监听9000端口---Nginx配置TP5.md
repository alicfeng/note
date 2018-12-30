**先来看看nginx的配置内容**

```nginx
server {
    listen 80;
    server_name    tp5.samego.com;
#    access_log    /app/logs/nginx/mydomain_access.log;
#    error_log    /app/logs/nginx/mydomain_error.log;
    set	$root	/home/alic/workspace/PHP/ThinkPHP/BasicThinkPHP5/public;
    location ~ .*\.(gif|jpg|jpeg|bmp|png|ico|txt|js|css)$
    {
        root $root;
    }
    location / {
        root    $root;
        index    index.html index.php;
        if ( -f $request_filename) {
            break;
        }
        if ( !-e $request_filename) {
            rewrite ^(.*)$ /index.php/$1 last;
            break;
        }
    }
    location ~ .+\.php($|/) {
	root $root;
	fastcgi_pass   127.0.0.1:9000;
        fastcgi_split_path_info ^((?U).+.php)(/?.+)$;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param    SCRIPT_FILENAME    $root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```


**Nginx配合PHP(ThinkPHP5)遇到的问题**

- `php5-fpm`一直无法监听9000端口

```nginx
2017/06/05 00:12:53 [error] 10350#0: *1 connect() failed (111: Connection refused) while connecting to upstream, client: 127.0.0.1, server: tp5.samego.com, request: "GET /index.html HTTP/1.1", upstream: "fastcgi://127.0.0.1:9000", host: "tp5.samego.com"
```

>解决方案如下：
>
>我的nginx配置文件：`/etc/nginx/sites-enabled/basicTP5.conf`，则修改如下文件
>
>`/etc/php5/fpm/pool.d/www.conf basicTP5.conf`
>
>修改内容为：将`listen = /var/run/php5-fpm.sock`修改成`listen = 9000`
>
>Then，既然修改配置完成那就重启两个服务：php-fpm 以及 nginx。

___

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
