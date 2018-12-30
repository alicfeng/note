**场景**
- 一台树莓派
- 一个启动U盘
- 一个移动硬盘
想在树莓派开机启动时自动挂载移动硬盘，u盘as系统盘 移动硬盘as数据盘。
___

**查看磁盘设备点,挂载设备**
~~~~
$sudo fdisk -l
~~~~
___


**通过ntfs-3g挂载NTFS格式硬盘**
- 手动挂载

~~~
#安装ntfs-3g
$sudo apt-get install ntfs-3g

#挂载处理
$mount -t ntfs-3g /dev/需要挂载的ntfs硬盘 /挂载的位置

#比如将sdb1挂载在/media/alic/NETAC
$mount -t ntfs-3g /dev/sdb1  /media/alic/NETAC
~~~
___

- 开机自动挂载
编辑`/etc/fstab`

~~~
# 备份文件
sudo cp /etc/fstab /etc/fstab.bak

#编辑并添加如下记录
sudo vim /etc/fstab
~~~
开机自动挂载 记录
~~~
/dev/需要挂载的ntfs硬盘 /挂载的位置  ntfs-3g default 0 0 
~~~
sample 开机自动挂载sdb1硬盘
~~~
/dev/sdb1 /media/alic/NETAC ntfs-3g default 0 0 
~~~
___

**挂载ext格式硬盘**
- 开机自动挂载
~~~
/dev/需要挂载的硬盘名 /挂载的位置/ ext4 default 0 0
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
