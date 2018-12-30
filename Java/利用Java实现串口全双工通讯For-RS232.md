- Install RS232 Driver For ubuntu
对于Ubuntu而言，RS232串口通信驱动模块已经是源码编译安装了的，但是未必已经驱动了的，需要我们手工驱动。
```shell
sudo modprobe usbserial
sudo modprobe pl2303
```
启动之后，我们可以查看系统加载驱动模块了没有，如下：
```
➜  ~ lsmod | grep pl2303
pl2303                 20480  0 
usbserial              40960  1 pl2303
```
倘若我们将串口设备插进USB接口后，我们可以使用`lsusb`查看的，但是目前我没有这个
```
➜  ~ lsusb
Bus 002 Device 003: ID 17ef:6039 Lenovo 
Bus 002 Device 002: ID 8087:0020 Intel Corp. Integrated Rate Matching Hub
Bus 002 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
Bus 001 Device 003: ID 147e:2016 Upek Biometric Touchchip/Touchstrip Fingerprint Sensor
Bus 001 Device 002: ID 8087:0020 Intel Corp. Integrated Rate Matching Hub
Bus 001 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
```

开机自动启动设置
方案：只要把模块名加到/etc/modules中即可，一个模块一行！

```
➜  ~ cat /etc/modules
# /etc/modules: kernel modules to load at boot time.
#
# This file contains the names of kernel modules that should be loaded
# at boot time, one per line. Lines beginning with "#" are ignored.
# Parameters can be specified after the module name.
lp

# 在这里的两个
usbserial
pl2303
```

___

- Java Code 
对于代码的实现控制，第一步肯定得搞好环境的了，少说点，好困！
对于项目环境(运行)环境的安装无非就是将三个文件进行拷贝，具体是这三个文件：comm.jar，javax.comm. properties和libLinuxSerialParallel.so(win下是win32comm.dll)。这三个文件具体方哪里呢？ps:如下全局配置
> 将comm.jar拷贝至$JAVA_HOME/lib/ext/目录下
> 将libLinuxSerialParallel.so拷贝至/usr/lib
> 将win32comm.dll拷贝至$JAVA_HOME/jre/bin/目录下(这个针对win32OS)
> javax.comm. properties拷贝至$JAVA_HOME/jre/lib/目录下
注意一下，在ubuntu下，libLinuxSerialParallel.so库文件可以还需要execstack，因为提示异常，一条命令即可搞定！
```shell
# 先安装execstack
sudo apt-get isntall execstack -y
sudo execstack -c /usr/lib/libLinuxSerialParallel.so
```

___
这里只是简单过一下流程，对于更加详细的API，在此我要感激一个贡献者，然而并不知道他是谁，THX！

![RS232 Java资料](http://upload-images.jianshu.io/upload_images/1678789-215c05e20820b2ef.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

[资料传送Github-alicfeng](https://github.com/alicfeng/Linux_env/blob/master/dev_data/api/java-rs232/java-rs232.7z)
___

Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**



