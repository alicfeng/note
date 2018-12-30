**前言**
当我们想要监控服务器的流量的时候，除了查看服务商提供的web面板数据以外，还是有很多途径的，比如：
- vnstat：网卡
- nethogs: 按进程查看流量占用
- iptraf: 按连接/端口查看流量
- ifstat: 按设备查看流量
- iftop: 实时监控流量(类似top)
- ethtool: 诊断工具
- tcpdump: 抓包工具
来记录记录去分享分享这次vnstat的尝鲜~~~
vnstat这个呢，很简洁，简洁产生美！
___

**安装与配置**
- insntall
~~~
sudo apt-get install vnstat
~~~
生成 vnStat 数据库：
~~~
sudo vnstat -u -i eth0
~~~
先说一个注意的地方：
默认是使用ech0，但是我的ubuntu16.04是enp4s0f2，看个人pc。如果你的网卡不是 eth0，则要修改成相应的网卡名称，并修改 /etc/vnstat.conf的 Interface "eth0"为你的网卡名称。
___


**常用的方法**
查看当前实时流量
~~~
vnstat -l
~~~
查看每天流量统计
~~~
vnstat -d
~~~
查看每月流量统计
~~~
vnstat -m
~~~
查看流量报表
~~~
vnstat
~~~
查看具体某个网卡实时流量
~~~
vnstat -l -i eth0
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-b29a744912d88d2b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


问题1：无法统计流量，有可能是数据文件的权限问题假设你的网卡是 enp4s0f2，进入 /var/lib/vnstat目录，把enp4s0f2修改成640即可。
