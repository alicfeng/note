**ownCloud简介**
ownCLoud的内核使用PHP5编写的，环境基于LAMP，是一个开源云服务项目，接下来就利用ownCLoud来搭建私有云。
___
**Step-One：搭建ownCloud依赖的环境[LAMP]**
A2Web服务器：`apache2` 
PHP语言：`php5` `php5-gd` `php-xml-parser` `php5-int` `l php5-sqlite` 
MySQL数据库：`mysql-server` `php5-mysql` 
SMB 挂载win文件共享：`smbclient` 
CURL：`curl` `libcurl3` `php5-curl` 
~~~
$ sudo apt-get install apache2 php5 php5-gd php-xml-parser php5-intl php5-sqlite php5-mysql smbclient curl libcurl3 php5-curl mysql-server
~~~
___
LAMP详细说明
[ubuntu搭建Apache+PHP+MySQL](http://www.jianshu.com/p/78c7cdf28305)
[ubuntu一步搭建Apache+MySQL+PHP环境](http://www.jianshu.com/p/ebdb0595c156)
___
**Step-Two：安装ownCloud**
~~~
#获取ownCloud已经编译好的包
wget https://download.owncloud.org/community/owncloud-9.0.2.tar.bz2
#解压owncloud-9.0.2.tar.bz2
tar xjf owncloud-4.5.6.tar.bz2
#将文件mv到apache2服务器映射的根目录[为了方便我放在用户目录/www]
sudo mv owncloud ./www/
#进入owncloud文件
cd owncloud
#owncloud需要对apps、data、config目录有write的权限，要是没有这三个文件需要手动创建
#由于wget下来的版本没有data，那么就来mkdir
mkdir data
#分别给予write权限  username替换成你的用户名
sudo chown -R username: username data
sudo chown -R  username: username config
sudo chown -R  username: username apps
#安装完成啦
~~~
___
**Step-Three：修改Apache2配置信息**
我是利用二级域名来映射到服务器的
- 修改apache2.conf配置
~~~
sudo nano /etc/apache2/apache2.conf
#添加如下的映射目录信息
~~~
- 
~~~
#cloud alic
<Directory /home/ubuntu/www/owncloud/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
~~~
- 修改虚拟主机映射信息
~~~
sudo nano /etc/apache2/sites-enabled/000-default.conf
#添加如下的信息
~~~
- 
~~~
#cloud alic
<VirtualHost *:80>
        ServerAdmin webmaster@cloud.example.com #example替换你的域名
        ServerName cloud.example.com
        DocumentRoot /home/ubuntu/www/owncloud
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
~~~

- 启动Apache的mod_rewrite模块 
方法一
~~~
sudo a2enmod rewrite
~~~
方法二
- 
~~~
#也可以修改配置文件
sudo nano /etc/apache2/mods-enabled/alias.load 
#添加这句话 ：LoadModule rewrite_module /usr/lib/apache2/modules/mod_rewrite.so
~~~
Apache详细说明
[本地集成xammp配置多域名](http://www.jianshu.com/p/ed6f7ca266b0)
___
**Step-Four：运行安装**
打开浏览器输入刚配置的二级域名cloud.example.com
既然搭建了LAMP的环境推荐使用MySQL,也可以使用SQLite省内存，不过服务器的MySQL在其它项目需要用到因而是开启的，既然开了就别浪费。
![配置管理员信息](http://upload-images.jianshu.io/upload_images/1678789-d8ca0cc5253eea15.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![成功进入欢迎界面.png](http://upload-images.jianshu.io/upload_images/1678789-97b4c3958c891cb6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
到此服务器端的ownCloud就安装完成！
___
**Step-Five：Linux文件管理器显示云存储**
- 复制你的 WebDAV 链接：在浏览器打开网盘的左下角点击设置然后复制 WebDAV 链接

![复制你的 WebDAV 链接](http://upload-images.jianshu.io/upload_images/1678789-460c2e0a70dff390.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 打开本地桌面文件管理器 选择【连接至服务器】如图
注意
服务器：填写刚复制的WebDAV 链接，不要前缀`http://或加密的https://`
用户名：ownCloud已经存在的用户
密码：ownCloud用户对应的密码
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-9a7383920eccaf97.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![成功登陆云储存](http://upload-images.jianshu.io/upload_images/1678789-89245246431e3dfa.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___


**Step-Six：挂载 WebDAV  For Linux 用户**
- 安装 davfs2 以及 fuse

~~~
sudo apt install fuse davfs2
~~~
- 创建ownCloud的挂载目录
 
~~~
# 下面username改成你的用户名
cd /media/username
sudo mkdir Cloud/
#给Cloud可写的权限
sudo chown -R username:username Cloud/
~~~
- 修改 davfs2 配置

~~~
#直接复制终端运行
sudo sed -i 's/# use_locks 1/use_locks 0/g' /etc/davfs2/davfs2.conf
~~~
~~~
#替换“网盘用户名 网盘密码”
#注意：该文件只有root账号才能查看、修改。
#使用sudo -i切换至root用户
echo "https://example.com/remote.php/webdav/ 网盘用户名 网盘密码" > /etc/davfs2/secrets
~~~
- 挂载Cloud
~~~
#切换至root用户
sudo -i
mount.davfs https://example.com/remote.php/webdav/ /media/username/Cloud/
#退出root用户
exit
#给予Cloud可写权限
cd /media/username & sudo chown -R username:username Cloud/
~~~
- 查看云盘容量：
~~~
df -h /media/username/Cloud/
~~~
- 卸载云盘：
~~~
sudo umount /media/username/Cloud/
cd  /media/username/ & sudo rm -r Cloud
~~~
![在挂载目录打开](http://upload-images.jianshu.io/upload_images/1678789-bd55f27c2eacb538.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

很好，对于文件的操作也会会同步处理！
为了不必折磨麻烦的其实还是有客户端的
~~~
sudo apt-get install owncloud-client
~~~
___
[ownCloud官网](https://owncloud.org/)
参考文章：
[图文教程：如何建立自己的私有云存储](http://www.cnblogs.com/lanxuezaipiao/archive/2013/05/27/3101883.html)
[一步搭建你的私密网盘](http://www.jianshu.com/p/792a5c1fa44b) docker搭建

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
