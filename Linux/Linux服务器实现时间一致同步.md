**前言**几时所有的服务器在同一个机房也难以保持时间的一致，在做服务器开发时，对时间的要求也是及其严格的，特别是在做分布式服务器/集群数据库等等，数据无价！运维的方法还是非常多的，但是我呢还是推荐使用ntpdate。
___
**ntpdate的原理**
还是一句话：以一个标准的时间作为一个基准，该时间可以随意你定，为了准确无误呢，还是使用某某官方的服务器的时间作为基准。
___
**ntpdate的安装**
ubuntu
~~~
sudo apt-get install ntpdate
~~~
centOS
~~~
sudo yum install utpdate
~~~
**ntpdate的使用**
~~~
#该ip为基准服务器的IP地址
#-u表示越过防火墙
ntpdate -u ip
#or 
ntpdate ip
~~~
___
注意：时间长了，还是有可能造成时间的不同步，在此同时还需要定时执行该命令保持时间一致，推荐一小时一次！
关于定时详细说明[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
