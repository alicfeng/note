**前言**
今天在专题收录一篇关于ngixn与apache2实现负载均衡的文章，仔细看了一遍，有些地方存在错误，记得之前搭建过这样的环境，今天呢，好好记录分享一下。

___
**nginx & apache**
简单说说它俩的优点
- nginx的并发量高、占用资源少，适用于前端或静态服务
- apache服务超级稳定，适用于后端或动态服务
___

**nginx & apache协作流程**
一般而言，我们可以使用nginx以及apache实现集群服务器负载均衡，具体如何实现的呢？它们的工作流程又是如何的呢？
- 第一步：客户端访问服务器的时候将会先访问nginx服务器
- 第二步：nginx接受客户端请求后将会将请求转发到apache
- 第三步：apache接收nginx的转发请求将会处理请求
- 第四步：apache将处理后的请求返回客户端，完成一次访问


![nginx & apache协作流程](http://upload-images.jianshu.io/upload_images/1678789-596bcc875786952a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

**Nginx的upstream分发机制**
upstream按照轮询（默认）方式进行负载，每个请求按时间顺序逐一分配到不同的后端服务器，如果后端服务器down掉，能自动剔除。虽然这种方式简便、成本低廉。但缺点是：可靠性低和负载分配不均衡。适用于图片服务器集群和纯静态页面服务器集群。基本有如下几种：
- 轮询( 默认 )
适用于图片服务器集群和纯静态页面服务器集群。
```
upstream balance{
    server localhost:8080;
    server localhost:8081;
    server localhost:8082;
   ... ...
}
```

- 指定权重
权重weight和访问比率成正比，用于后端服务器性能不均的情况。
```
upstream balance{
    server localhost:8080 weight=5;
    server localhost:8081 weight=10;
    server localhost:8082 weight=15;
   ... ...
}
```

- IP绑定 ip_hash
每个请求按访问ip的hash结果分配，这样每个访客固定访问一个后端服务器，可以解决session的问题 
```
upstream balance {
    ip_hash;
    server localhost:8080;
    server localhost:8081;
    server localhost:8082;
    ... ...
}
```

- fair（第三方）
按后端服务器的响应时间来分配请求，响应时间短的优先分配。 
```
upstream balance {
    fair;
    server localhost:8080;
    server localhost:8081;
    server localhost:8082;
    ... ...
}
```
___

**nginx & apache安装**
```
# 对于安装不多说(基于debian/ubuntu)
sudo apt-get install apache2 nginx -y
```
___
#### 重点将在如下
对于更多的负载均衡理论可以自行搜索，这里旨在实践配置。

**环境场景**
为了方便配置，所有的服务都是安装在同一台机器上面。
>Apache版本：Apache/2.4.7 (Ubuntu)
Nginx版本： nginx/1.4.6 (Ubuntu)
___
- nginx服务器只需要一台服务器即可，它的http服务器的端口使用默认的80，
- apache启动多个端口，模拟多台服务器的80端口。端口分别为8001、8002、8003、8004。
- 我们将客户端的请求通过nginx分别按照指定的分发机制转发到apache的8001、8002、8003、8004端口。
- nginx采取权重的分发机制


**配置Apache**
前提：将默认的80端口关闭，因为80端口将为nginx所用。将默认的`000-default.conf.bak`重命后缀名即可(非conf)。
(1) 开启端口监听允许
       在apache端口蒋婷配置文件`/etc/apache2/ports.conf`添加如下信息，记得关闭80端口监听。
```
Listen 8001
Listen 8002
Listen 8003
Listen 8004
```
(2) 配置虚拟目录映射
         个人习惯，将每一个虚拟目录配置写一个配置文件，在这里将新建四个conf文件，对应的配置如下：
`/etc/apache2/ites-enabled/8001.conf`
```
<VirtualHost *:8001>
    ServerAdmin localhost:8001
    DocumentRoot /home/alic/www/proxy/8001
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

```
`/etc/apache2/ites-enabled/8002.conf`
```
<VirtualHost *:8002>
    ServerAdmin localhost:8002
    DocumentRoot /home/alic/www/proxy/8002
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

```
剩下的8003.conf、8004.conf就不多说了！
(3) 重启Apache，没有问题浏览器就可以直接打开各个端口的访问了
```
sudo service nginx restart
```
___

**配置Nginx**
(1) upstream
定义一个upstream变量，即定义接收转发的服务器
`/etc/nginx/sites-enabled/default`
```
#代理转发地址
upstream balance{
	server localhost:8001 weight=5;
	server localhost:8002 weight=10;
	server localhost:8003 weight=15;
	server localhost:8004 weight=20;	
}
```
(2) server
配置监听80端口的server，将请求转发到upstream
`/etc/nginx/sites-enabled/default`
```
server {
	listen 80 default_server;
	listen [::]:80 default_server ipv6only=on;
	server_name localhost;

	location / {
		try_files $uri $uri/ =404;
		#修改proxy_pass这里即可
		proxy_pass http://balance;
	}
```
(3) 重启nginx
```
sudo service nginx restart
```
至此，已经配置完成了，我们可以检验检验！！！
```
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8003
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8004
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8004
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8001
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8001
➜  ~ curl 127.0.0.1
I am proxy apache2 port 8002
... ...
```
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**








