前言：前段时间就看了一些关于Nginx服务器的一些资料，然而知道Nginx这款服务器，它可以用来做**反向代理服务器**，也可以做**负载均衡**。于是今天下午搭建了Nginx服务器去尝试做反向服务器代理。
___
**Nginx服务器反代理的好处**
简单地来说，反代理可以将各独立的并没有关联的主机绑定在同一个域名。
___
下面就来体验一下Nginx服务器反代理
Step-One：前提是已经安装了Nginx服务器
~~~
sudo apt-get install nginx #要是没有安装可以执行此install命令
~~~
Step-Two：将你的域名映射到你要代理的主机的IP，一般的话就是以A记录来解析
Step-Three：修改Nginx的配置文件/etc/nginx/sites-enabled/default
~~~
sudo nano /etc/nginx/sites-enabled/default
~~~
修改成如下
~~~
server {
    #修改这里 我将 80 改为 88 
    listen 88 default_server;
    #监听端口也将80改成88
    listen [::]:88 default_server ipv6only=on;

    root /app;
    index index.html index.htm;

    server_name localhost;

    location / {
        try_files $uri $uri/ =404;
    }
}
# 上面是默认的不用管也可以,修改是为了与Apache端口发生冲突。
server
{
    listen 88;
    server_name lab.example.com; # 这里填自定义域名
    location / {
        proxy_redirect off;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_pass http://172.16.168.35:1010; # 这里填写反代理的IP，可以添加端口
    }
}
~~~
步骤到此结束，反代理就简单配置完成！
___
**价值源于技术，贡献源于分享**
[Nginx服务器反代理配置](http://www.jianshu.com/p/5d36ccb5af88)
[Apache2反代理配置](http://www.jianshu.com/p/15538d9f7a67)
参考资料
[为“复杂”的容器环境配置Nginx反向代理](http://www.jianshu.com/p/5a5e94cb98c5)
