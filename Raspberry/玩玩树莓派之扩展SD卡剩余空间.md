前言：在安装好Go环境之后万事俱备只欠东风的情况下，我充满了喜悦，正准备go get -u github.com/gogits/gogs，然而fatal: write error: No space left on device说我的磁盘不足了哇，说多了都是泪，想了想会不会是SD卡还有一部分剩余的容量没有使用呢，果然不出我所料。
___
首先来查看一下系统的磁盘情况
~~~
df -h
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-8fd75190066ee1ff.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
你会发现：树莓派只识别出2.9G的容量,虽然如此，但是还是由办法解决的。
___
解决办法：
~~~
pi@raspberrypi ~ $ df -h #查看当前磁盘大小，总大小只有2.9GB
Filesystem      Size  Used Avail Use% Mounted on
rootfs          2.9G  2.8G   15M 100% /
/dev/root       2.9G  2.8G   15M 100% /
devtmpfs        214M     0  214M   0% /dev
tmpfs            44M  244K   44M   1% /run
tmpfs           5.0M     0  5.0M   0% /run/lock
tmpfs            88M     0   88M   0% /run/shm
/dev/mmcblk0p1   56M   19M   37M  34% /boot
tmpfs            88M     0   88M   0% /tmp


pi@raspberrypi ~ $ cat /sys/block/mmcblk0/mmcblk0p2/start   # 查看第二分区的起始地址，后面会用到
122880


pi@raspberrypi ~ $ sudo fdisk /dev/mmcblk0   #使用fdisk操作磁盘

Command (m for help): d   #d，删除分区
Partition number (1-4): 2   # 2，删除第二分区

Command (m for help): n  #创建一个新分区
Partition type:
   p   primary (1 primary, 0 extended, 3 free)
   e   extended
Select (default p): p  #创建主分区
Partition number (1-4, default 2): 2  #分区2
First sector (2048-7744511, default 2048): 122880  #输入第一次得到的第二分区起始扇区
Last sector, +sectors or +size{K,M,G} (122880-7744511, default 7744511):  #最后一个sector，默认即可Enter
Using default value 7744511

Command (m for help): w   #将上面的操作写入分区表
The partition table has been altered!

Calling ioctl() to re-read partition table.

WARNING: Re-reading the partition table failed with error 16: Device or resource busy.
The kernel still uses the old table. The new table will be used at
the next reboot or after you run partprobe(8) or kpartx(8)
Syncing disks.


pi@raspberrypi ~ $ sudo reboot  #设置完成需要重启，sudo reboot
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-da0eddb621721a7a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
重启完成之后，此时查询也还是没有变化的，还需要如下命令
~~~
sudo resize2fs /dev/mmcblk0p2
~~~
这时你再来查询树莓派的系统磁盘的容量就扩展啦，看图！

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-bd96efa833fb3666.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

这样就可以解决树莓派只识别出SD卡2.9G的容量的问题！
___
关于树莓派文章
[树莓派OS装机初始化](http://www.jianshu.com/p/8e884110b5b4)
 [玩玩树莓派之自动连接无线路由器](http://www.jianshu.com/p/34cfa07e623f)
[玩玩树莓派之扩展SD卡剩余空间](http://www.jianshu.com/p/6588f935d41c)
[玩玩树莓派之配置Go环境](http://www.jianshu.com/p/4c79aec8b5e7)
