前言：之前我一直没有亲自尝试过刻录树莓派img，今天中午拿到了网购的SD卡就亲自尝试了一下，虽然是装在SD卡里，但是和导入到U盘或硬盘几乎没有区别。next do！
####树莓派烧录至SD卡####
linux 使用**dd**命令
~~~
sudo dd if=/home/alic/Alic/Share/2015-11-21-raspbian-jessie-lite.img of=/dev/sdb #if=为镜像文件路径，of=img的输出设备
~~~
or
windows使用**Win32DiskImager**
___
####更换树莓派源####
~~~
sudo cp /etc/apt/sources.list /etc/apt/sources.list.bak #安全起见，备份源文件
sudo nano sources.list
~~~
修改之后的内容如下：
~~~
#使用大连东软信息学院软件源镜像
deb http://mirrors.neusoft.edu.cn/raspbian/raspbian wheezy main contrib non-free rpi 
~~~
~~~
sudo apt-get update #记得就好
~~~ 
___

**价值源于技术，贡献源于分享**

关于树莓派文章
[树莓派OS装机初始化](http://www.jianshu.com/p/8e884110b5b4)
 [玩玩树莓派之自动连接无线路由器](http://www.jianshu.com/p/34cfa07e623f)
[玩玩树莓派之扩展SD卡剩余空间](http://www.jianshu.com/p/6588f935d41c)
[玩玩树莓派之配置Go环境](http://www.jianshu.com/p/4c79aec8b5e7)
