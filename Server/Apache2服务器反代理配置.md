前言：对于反代理这个词呢，总会想到nginx服务器，然而今天想让apache与nginx在同一个端口跑，不知道是我玩挂了还是nginx不稳定，时而正常时而~~，由于weblogic在多model的情况下url总是带有war_exploded的，然而我就尝试用apache2反代理到内网weblogic服务器。
___
**Step-One：使用a2enmod命令加载proxy模块**
~~~
sudo a2enmod proxy proxy_balancer proxy_http
~~~
___
**Step-Two：修改主机站点配置文件**
path:`/etc/apache2/sites-enabled/000-default.conf`
~~~
<VirtualHost *:80>
        #自定义域名
        ServerName example.com
        #off表示开启反向代理，on表示开启正向代理
        ProxyRequests Off
        ProxyMaxForwards 100
        ProxyPreserveHost On
        #反代理要解析的ip 支持添加端口 
        ProxyPass / http://172.16.168.35:7001/
        ProxyPassReverse / http://172.16.168.35:7001/

        <Proxy *>
            Order Deny,Allow
            Allow from all
        </Proxy>
</VirtualHost>
~~~
___
**价值源于技术，贡献源于分享**
[Nginx服务器反代理配置](http://www.jianshu.com/p/5d36ccb5af88)
[Apache2反代理配置](http://www.jianshu.com/p/15538d9f7a67)
