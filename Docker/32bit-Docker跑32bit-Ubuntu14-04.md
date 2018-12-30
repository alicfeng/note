**前言**
听过32bit-机器玩Docker的吗？我就是其中一个。为啥你要这么屌( ⊙o⊙ )哇，不不不，原因很简单：因为穷书生没有钱，穷到只能玩腾讯云一块钱一个月的云主机，好处就是64bit的服务器，但是腾讯云的服务器网络超B的慢，只有20多K，不知道便宜的原因呢，还是国内的原因，好吧～～～应该两者都有。之前还折腾我的电脑安装64bit的系统，折腾了好几天，最终还是以失败而告终，然而换了角度来跑Docker：折腾去找docker的32为的镜像。目前，仅仅找到了ubuntu-32bit的Docker镜像。
___
安装docker就不多说了
~~~
$sudo apt-get install docker.io
~~~
___
**Step-One：下载32bit的ubuntu的镜像**
[点击这里下载ubuntu-14.04-x86镜像](http://download.openvz.org/template/precreated/ubuntu-14.04-x86-minimal.tar.gz)

**Step-Two：将镜像导入Docker**
~~~
sudo cat ubuntu-14.04-x86-minimal.tar.gz | docker import - ubuntu:14.04
~~~

**Step-Three：运行ubuntu镜像**
~~~
sudo docker run -it ubuntu:14.04 /bin/bash
~~~

![laucher](http://upload-images.jianshu.io/upload_images/1678789-c487f5f8e67a2dc4.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
温馨提示：跑完的镜像记得保存其状态
~~~
#比如保存成iamge：ubuntu:demo
sudo docker commit container_id ubuntu:demo
#下次启动的话就是
#sudo docker run -it ubuntu:demo
~~~
