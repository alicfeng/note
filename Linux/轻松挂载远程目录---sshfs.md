**前言**
    最近nfs远程挂载目录有点问题，暂时懒得搞，但是方法不但仅仅只有nfs的，比如解决方案还有sshfs，sshfs远程挂载目录基于ssh，特点那就是简洁又安全。
___
不多说了！
**安装**
```shell
➜  ~ sudo apt-get install sshfs
```
___

**轻松使用**
挂载远程目录
```shell
sshfs $user@$host:$remote_dir_path $local_dir_path 
```
卸载远程挂载目录
```shell
➜  ~ fusermount $local_dir_path 
```

此时的你也许会问，要输入密码，麻烦，这可是基于ssh的，可以免秘钥的，当然还可以这么做
举个例子哈
```shell
➜  ~ sshfs -o ssh_command='sshpass -p ppppp ssh' alic@172.16.168.1:/media/alic/asus /home/alic/mount/172.16.168.1/asus 
```

![AlicFeng mount dir](http://upload-images.jianshu.io/upload_images/1678789-df3eb747f6daa8df.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
PS：对于其它命令参数可以查看help或者官方API
___
对于我仅仅挂载远程还是不够的，我需要将文件同步，那我再次就推荐一个轻量级比较&&同步的工具**meld**。
安装meld
```shell
➜  ~ sudo apt-get install meld
```
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
