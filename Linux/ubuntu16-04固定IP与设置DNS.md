**前言**
学校几乎每次断电之后，宿舍的机器IP基本都会更改，即使可以通过图形界面去修改，但还是懒得去改。但是docker某些容器的应用需要具体使用ip，比如程序code使用docker-mysql容器的话【localhost以及127.0.0.1->error】。记录一下ubuntu16.04在非图形界面固定IP与设置DNS。
___
**ubuntu16.04固定IP**
**Step-One【Ubuntu-server跳过】**
~~~
sudo vim /etc/NetworkManager/NetworkManager.conf
# 将`managed=false`修改成`managed=true`
sudo reboot
~~~
___

**Step-Two**
~~~
# 备份
sudo cp  /etc/network/interfaces /etc/network/interfaces.bak

# 修改配置文件
sudo vim /etc/network/interfaces
~~~
改成如下：
~~~
# 自动挂载enp4s0f2网卡
auto enp4s0f2
iface enp4s0f2 inet static  
# 静态IP
address 172.16.168.128
# 网关地址
gateway 172.16.168.254  
# 子网掩码
netmask 255.255.255.0  
#network 192.168.2.0  
# 广播地址
#broadcast 192.168.2.255
~~~
___

**Step-Three**
~~~
# 重启networking服务
sudo systemctl restart networking.service
~~~


___
___
**ubuntu16.04设置DNS**
~~~
# 默认文件不存在
sudo vim /etc/resolvconf/resolv.conf.d/base
~~~
添加下面内容：
~~~
meserver 8.8.8.8
nameserver 8.8.4.4
# sise-dns
nameserver 172.16.2.1
nameserver 172.16.2.6
~~~
~~~
刷新配置文件
sudo resolvconf -u
~~~
___




**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**




