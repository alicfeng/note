**前言**
心累了，没有配置好Nginx整合ThinkPHP的话，啥提示也没有，之前一直将tp框架项目部署在apache服务器上面，记录这次让Nginx支持ThingPHP的rewrite路由模式。

LNMP基于docker构建

**解决方案**

- 修改网站虚拟主机的配置文件 **.conf

~~~
server {
    listen  8090;

    server_name  localhost;

    location / { 
        root   /www/backstage/;
        index  index.htm index.html index.php;  
        #访问路径的文件不存在则重写URL转交给ThinkPHP处理  
        if (!-e $request_filename) {  
           rewrite  ^/(.*)$  /index.php/$1  last;  
           break;  
        }  
    }  

    location ~ \.php/?.*$ {  
        root           /www/backstage/;
        fastcgi_pass   __DOCKER_PHP_FPM__:9000;
        fastcgi_index  index.php; 
        #加载Nginx默认"服务器环境变量"配置  
        include        fastcgi.conf;  
          
        #设置PATH_INFO并改写SCRIPT_FILENAME,SCRIPT_NAME服务器环境变量  
        set $fastcgi_script_name2 $fastcgi_script_name;  
        if ($fastcgi_script_name ~ "^(.+\.php)(/.+)$") {  
            set $fastcgi_script_name2 $1;  
            set $path_info $2;  
        }  
        fastcgi_param   PATH_INFO $path_info;  
        fastcgi_param   SCRIPT_FILENAME   $document_root$fastcgi_script_name2;  
        fastcgi_param   SCRIPT_NAME   $fastcgi_script_name2;  
    }  
}

~~~

___


- 配置TP框架的conf

~~~
/**
 * 路由配置
 */
'URL_ROUTER_ON' => true,      //开启路由
'URL_MODEL' => 2,
~~~

___

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
