**FTP简介**
vsftpd(Very Security File Transfer Protocol)是一款在Linux发行版中最受推崇的FTP服务器程序。特点是小巧轻快，安全易用。并且是一个完全免费开放源码的ftp软件。
___
**安装FTP**
~~~
which vsftpd #检测是否已经安装vsftpd
~~~
~~~
sudo apt-get install vsftpd
~~~
___
**更改启动状态**
~~~
sudo service vsftpd start #开启ftp服务
~~~
~~~
service vsftpd status #查看FTP的状态
~~~
~~~
sudo service vsftp stop #停止ftp服务
~~~
~~~
sudo service vsftp restart #重启ftp服务
~~~
~~~
sudo /etc/init.d/vsftpd restart #倘若上面的不行就使用路径的形式直接执行 
~~~
~~~
sudo pkill vsftpd #有时候停止失败就干掉吧
~~~
___
**FTP用户管理** ex:user->share
增加share用户
~~~
sudo useradd -d /home/share share
~~~
为用户添加密码
~~~
sudo passwd share 
~~~
删除share用户
~~~
sudo userdel share
~~~
更改用户的权限
~~~
sudo usermod -s /sbin/nologin share  #用户share不能telnet 只能FTP
~~~
~~~
sudo usermod -s /sbin/bash share  #用户share恢复权限
~~~
~~~
sudo usermod -d /home/alic/share  share #更改share用户的主目录
~~~
___
**FTP的基本配置信息vsftpd.conf**
~~~
ftpd_banner=welcome to ftp service  #设置连接服务器后的欢迎信息
~~~
~~~
idle_session_timeout=60 #限制远程的客户机连接后，所建立的控制连接，在多长时间没有做任何的操作就会中断(秒)
~~~
~~~
data_connection_timeout=120 #设置客户机在进行数据传输时,设置空闲的数据中断时间
~~~
~~~
accept_timeout=60 #设置在多长时间后自动建立连接
~~~
~~~
connect_timeout=60 #设置数据连接的最大激活时间，多长时间断开，为别人所使用;
~~~
~~~
max_clients=200 #指明服务器总的客户并发连接数为200
~~~
~~~
max_per_ip=3 #指明每个客户机的最大连接数为3
~~~
~~~
local_max_rate=50000(50kbytes/sec)  #本地用户最大传输速率限制
~~~
~~~
anon_max_rate=30000 #匿名用户的最大传输速率限制
~~~
~~~
pasv_min_port=21 #端口21
~~~
~~~
pasv-max-prot= #端口号 定义最大与最小端口，为0表示任意端口;为客户端连接指明端口;
~~~
~~~
listen_address= #IP地址 设置ftp服务来监听的地址，客户端可以用哪个地址来连接;
~~~
~~~
listen_port= #端口号 设置FTP工作的端口号，默认的为21
~~~
~~~
chroot_local_user=YES  #设置所有的本地用户可以chroot
~~~
~~~
chroot_local_user=NO #设置指定用户能够chroot
~~~
~~~
chroot_list_enable=YES
~~~
~~~
chroot_list_file=/etc/vsftpd/chroot_list #只有/etc/vsftpd/chroot_list中的指定的用户才能执行 
~~~
~~~
local_root=path #无论哪个用户都能登录的用户，定义登录帐号的主目录, 若没有指定，则每一个用户则进入到个人用户主目录;
~~~
~~~
chroot_local_user=yes/no  #是否锁定本地系统帐号用户主目录(所有);锁定后，用户只能访问用户的主目录/home/user,不能利用cd命令向上转;只能向下;
~~~
~~~
chroot_list_enable=yes/no #锁定指定文件中用户的主目录(部分),文件：/chroot_list_file=path 中指定;
~~~
~~~
userlist_enable=YES/NO #是否加载用户列表文件;
~~~
~~~
userlist_deny=YES 表示上面所加载的用户是否允许拒绝登录;
~~~
~~~
userlist_file=/etc/vsftpd/user_list  #列表文件
~~~
限制IP 访问FTP:
~~~
sudo nano /etc/hosts.allow
vsftpd:192.168.5.128:DENY 设置该IP地址不可以访问ftp服务
~~~
___
遇到的问题: 登陆的时候一直出现**530 Login incorrect**
原因：因为vsftpd对用户进行了限制
解决方法：修改配置文件
~~~
sudo nano /etc/pam.d/vsftpd
~~~
将auth行加上#注释即可！
___
登录ftp后会发现，share用户可以访问其他目录，虽然不能对其他文件做修改，但是这样做是不允许的，我们需要将share用户的访问范围控制在其主目录下。解决方法如下：
Stept-One:
cd /etc/vsftpd 进入ftp配置文件目录
Stept-Two:
 vi vsftpd.conf编辑此文件,找到**#chroot_list_enable=YES**,删除前面的那个#号,表示开启此限制功能找到chroot_list_file：chroot_list_file=/etc/vsftpd/chroot_list.conf （默认没有该文件需要新建),还要添加**allow_writeable_chroot=YES**
Stept-Three:
 编辑chroot_list.conf文件,加入你要限制的用户名,一行一个用户.
___
