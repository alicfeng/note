**前言：**
今晚快要下班的时候，cp文件夹到U盘里面，由于文件过大并且里面的文件都是代码小文件，想想接近700M大有多少小文件，然而电脑就发烧式的发烫，真不敢想象呢，前所未有的发热，于是我就想关机来让电脑来歇歇，万万没想到的就是，电脑关机出现异常了，这时候我已经意识到电脑maybe出了问题。然后我就立马开机，果然不出我所料，电脑系统进不了了。来公司前我安装了linux+win双系统，电脑开机默认进入的是win系统，看到提示，感觉是win除了问题，真是奇怪：上次使用win系统都没有问题的，让你win飞吧～～～
___
**我的解决思路**
既然感觉是win除了问题，那么我就将win系统盘给删除，让它滚吧，然后就修复ubuntu的引导
___
**解决方案**
Step-One：制造启动盘
系统已经进不了了，那么我们就得使用u盘做一个启动盘，在linux上做ubuntu的启动盘是最简单的，通过**dd**命令,简直是简单粗暴明了。

Step-Two：获取linux系统分区编号
~~~
$df -h
~~~

![嘿嘿](http://upload-images.jianshu.io/upload_images/1678789-691f252675d004c1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
我的系统盘安装安装在sda8

Step-Three：挂载系统所需要的目录
~~~
$sudo mount /dev/sda3 /mnt
$sudo mount --bind /dev /mnt/dev
$sudo mount --bind /proc /mnt/proc
$sudo mount --bind /sys /mnt/sys
~~~

Step-Four：以root的方式登陆
~~~
sudo chroot /mnt
~~~

Step-Five：安装与更新引导grub
~~~
grub-install /dev/sda
grub-mkconfig -o /boot/grub/grub.cfg
#查资料也可能是下面的grub2
#grub2-install /dev/sda
#grub2-mkconfig -o /boot/grub2/grub.cfg
~~~

Step-Six：既然grub都修复okay啦，那么就卸载刚在挂载的目录
~~~
#不着急先退出root用户
exit
$sudo umount /mnt/dev
$sudo umount /mnt/proc
$sudo umount /mnt/sys
$sudo umount /mnt
~~~

Step-Seven：重启系统
___

**注意的地方**
1.安装与更新引导的命令不同的系统版本有不同的命令，上面已经有说明
2.查看系统分区的话，可以使用u盘启动自带的gparted可视化分区软件，不过我习惯了命令。
3.要是您的双系统windows引导出了问题的话，不妨可以试试。
___

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**












