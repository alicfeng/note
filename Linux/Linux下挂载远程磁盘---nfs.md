**前言：**
        额～我有两台Linux系统的主机，想将一台主机上的磁盘或者某个目录共享给另一台主机，说白了就是：**多台Linux主机使用同一个磁盘或目录。**

___

**解决方案：**
        使用nfs(network file system)网络文件系统工具，它是通过网络使不同机器或者操作系统之间分享部分文件，用于宿主机和目标机之间的文件分享。
___
**场景：**
- 服务端( 硬盘本地宿主主机 )：
`IP` ：172.16.168.1
`共享目录`：/media/alic/asus 
- 客户端( 将远程挂载磁盘主机 )：
`IP`：172.31.131.151
`挂载路径`：/home/alic/Alic/share
___
**安装nfs**`(两台主机都需要安装)`
- debain/ubuntu
```shell
sudo apt-get install -y  nfs-kernel-server
 ```

**配置**
- 服务端
(1) 在`/etc/exports`文件添加可以共享的文件夹和允许的客户端地址
```
/media/alic/asus 172.31.131.151(rw,no_root_squash,async)
```
(2) 重启nfs服务
```shell
➜  ~ sudo systemctl restart nfs-server.service
```

- 客户端
(1) 先创建挂载的目录
```
➜  ~ sudo mkdir /home/alic/Alic/share
```
(2) 挂载远程磁盘
```
➜  Alic sudo mount -t nfs 172.16.168.1:/media/alic/asus /home/alic/Alic/share
```
___
至此，我们已经配置完成了！来看看能否okay
```
# 服务端
➜  ~ ssh alic@172.16.168.1 "ls /media/alic/asus"       
alic@172.16.168.1's password: 
Alic
Coding
data
Extras
Linux
Mac
mobile
music
Video
VirtualBox VMs
Windows
未整理
文档
资料

# 客户端
➜  ~ ssh alic@172.31.131.151 "ls /home/alic/Alic/share"
alic@172.31.131.151's password: 
Alic
Coding
data
Extras
Linux
Mac
mobile
music
Video
VirtualBox VMs
Windows
未整理
文档
资料
```
(⊙o⊙)嗯！可以了~
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
