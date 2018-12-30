前言：昨晚以为下载了Gogs可以直接运行，结果出乎意料**cannot execute binary file**,系统cpu架构不能执行这个二进制文件，那就只好下源码编译，这又需要依赖Go，并且version>=1.4.0,那就先搭配Go的环境。
___
**Step-One：下载Go源码**
对于64位Linux
~~~
wget https://storage.googleapis.com/golang/go1.4.1.linux-amd64.tar.gz
~~~
对于32位Linux
~~~
wget https://storage.googleapis.com/golang/go1.4.1.linux-386.tar.gz
~~~
___
**Step-Two：在/usr/local下安装程序**
~~~
$ sudo tar -xzf go1.4.1.linux-xxx.tar.gz -C /usr/local
~~~
___
**Step-Three：编译源码**
~~~
cd /usr/local/go/src
sudo ./all.bash
~~~
___
**Step-Four：配置Go的环境变量**
~~~
#go language
export GOROOT=/usr/local/go
export GOPATH=$HOME/go
export PATH=$PATH:/usr/local/go/bin
~~~
___
**Step-Five：使配置文件生效**
~~~
source $HOME/.profile
~~~
or
~~~
sudo reboot #哈哈就是重启，怎么使用上一条生效有时候不管用的，还是重启吧
~~~
___
**Step-Six：检测环境是否安装成功**
~~~
go version
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-8d00f6e40c411b70.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
玩玩树莓派之配置Go环境配置完毕！
还有一种install的方法安装，不用下载源码编译，既麻烦又编译时间又长，美中不足的就是go的版本很低version-1.0.2，然而我需要的版本必须>=1.4.0，最终还是要编译。
~~~
sudo apt-get install golang
~~~
___
关于树莓派文章
[树莓派OS装机初始化](http://www.jianshu.com/p/8e884110b5b4)
 [玩玩树莓派之自动连接无线路由器](http://www.jianshu.com/p/34cfa07e623f)
[玩玩树莓派之扩展SD卡剩余空间](http://www.jianshu.com/p/6588f935d41c)
[玩玩树莓派之配置Go环境](http://www.jianshu.com/p/4c79aec8b5e7)
