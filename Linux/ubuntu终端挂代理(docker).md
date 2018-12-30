**前言**
最近呢没什么事，8.21以及10.15已经~~~。额额都在玩docker，并且听到左蓝使用docker搭建冕旒服务，因而我就具体玩了玩终端代理。比较流行的有Privoxy、Proxychains和Polipo，其中我感觉prixoxy比proxychains便利多了。
____


**认识privoxy**

百度百科say:
Privoxy是一款带过滤功能的代理服务器，针对HTTP、HTTPS协议。通过Privoxy的过滤功能，用户可以保护隐私、对网页内容进行过滤、管理cookies，以及拦阻各种广告等。Privoxy可以用作单机，也可以应用到多用户的网络。
Privoxy基于Internet Junkbuster，按照GNU General Public License进行发布。可以在Linux、Windows、Mac OS X、AmigaOS、BeOS，以及各种Unix上运行。

___
**安装以及配置privoxy**
ubuntu安装
~~~
sudo apt-get install privoxy
~~~
privoxy的默认配置文件的目录
~~~
/etc/privoxy/config
~~~
主要的配置有两个http协议监听以及socks5协议转换
~~~
#位置 4.1 默认监听端口(推荐不修改)
listen-address 127.0.0.1：8118

#位置5.2 9999为我的socks5代理端口
forward-socks5  /  127.0.0.1:9999  .
~~~
既然配置完成，那就重启privocy服务
~~~
sudo /etc/init.d/privoxy restart
~~~
至此呢，privoxy代理就配置完成了~
___


**终端配置代理参数**
~~~
#代理
export http_proxy="127.0.0.1:8118"
export https_proxy="127.0.0.1:8118"
~~~

终端就可以使用代理了，但是呢，智障的docker还是不可以的。

___

**docker跑终端挂代理**
创建一个配置文件
~~~
$sudo mkdir /etc/systemd/system/docker.service.d
$sudo vim /etc/systemd/system/docker.service.d/http-proxy.conf
~~~
配置内容如下：端口为privoxy的http监听端口
~~~
Environment="HTTP_PROXY=http://127.0.0.1:8118"
~~~
验证下配置是否正常加载
~~~
sudo systemctl show --property=Environment docker
~~~
重启docker
~~~
sudo systemctl restart docker
~~~

至此呢，okay啦，还是hello-world喽
~~~

~~~





