**前言**
今天实在时有空，了解过MySQL主从复制，虽然很简单，但是也要配置配置测试测试，想要至少两台的MySQL服务器，然而第一方法想到的就是Docker跑ubuntu容器，在ubuntu里面安装MySQL服务，虽然也可以使用腾云云服务器，我偏偏就是不干，就是想学习掌握Docker应用，其实我在32位主机玩Docker也是一种折腾。还是说说我的问题吧～～～
___
~~~
apt-get install mysql-server mysql-common mysql-client
~~~
**出现的问题**
~~~
debconf: delaying package configuration, since apt-utils is not installed
(Reading database ... 13606 files and directories currently installed.)
Preparing to unpack .../mysql-server-5.5_5.5.50-0ubuntu0.14.04.1_i386.deb ...
debconf: unable to initialize frontend: Dialog
debconf: (No usable dialog-like program is installed, so the dialog based frontend cannot be used. at /usr/share/perl5/Debconf/FrontEnd/Dialog.pm line 76.)
debconf: falling back to frontend: Readline
Aborting downgrade from (at least) 5.6 to 5.5.
If are sure you want to downgrade to 5.5, remove the file
/var/lib/mysql/debian-*.flag and try installing again.
dpkg: error processing archive /var/cache/apt/archives/mysql-server-5.5_5.5.50-0ubuntu0.14.04.1_i386.deb (--unpack):
 subprocess new pre-installation script returned error exit status 1
debconf: unable to initialize frontend: Dialog
debconf: (No usable dialog-like program is installed, so the dialog based frontend cannot be used. at /usr/share/perl5/Debconf/FrontEnd/Dialog.pm line 76.)
debconf: falling back to frontend: Readline
Selecting previously unselected package mysql-server.
Preparing to unpack .../mysql-server_5.5.50-0ubuntu0.14.04.1_all.deb ...
Unpacking mysql-server (5.5.50-0ubuntu0.14.04.1) ...
Errors were encountered while processing:
 /var/cache/apt/archives/mysql-server-5.5_5.5.50-0ubuntu0.14.04.1_i386.deb
E: Sub-process /usr/bin/dpkg returned an error code (1)

~~~
在网络上，同样的问题，相同的方案，我的却不能解决，我还以为是Docker里跑的问题，好吧，最好Google到了另一个解决方案。
___
**解决方案**
~~~ 
$apt-get purge mysql*
$apt-get autoremove
$apt-get autoclean
$apt-get dist-upgrade
$apt-get upgrade
$apt-get install mysql-server --fix-missing --fix-broken
~~~
搞掂！然而还是给出网上很主流我却搞不掂的方案，说不定。。。呢，嘿嘿！
~~~
sudo rm /var/lib/mysql/ -R
sudo rm /etc/mysql/ -R
sudo apt-get autoremove mysql* --purge
sudo apt-get remove apparmor
sudo apt-get install mysql-server mysql-common
~~~

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
