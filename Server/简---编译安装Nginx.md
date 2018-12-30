**前言**
端午节安康~
好长时间没有更新简书了，之前简书md格式以前不标准的写法竟然不支持了，现在得重新码一份出来~
为何爱上源码编译安装的方式呢？
so simple~
 - 源码安装可以自定义指定安装路径，可以自定义配置安装配套的库和插件
- 作为运维的我更加清楚服务器的情况，对以后的维护、升级就更加简易

___

**env & version**
 - CentOS 7.2
- Nginx 1.12.2

___

**install basic app**
~~~shell
sudo yum -y install gcc automake autoconf libtool make
sudo yum install gcc gcc-c++ glibc
~~~

___

**create base dir**
~~~shell
mkdir -p /home/alic/dl \
/home/alic/service/nginx 
~~~

___

**download & unzip pcre**
~~~shell
cd /home/alic/dl
wget https://sourceforge.net/projects/pcre/files/pcre/8.41/pcre-8.41.tar.gz
tar -zxvf pcre-8.41.tar.gz
~~~

___

**download & unzip zlib**
~~~shell
cd /home/alic/dl
wget https://sourceforge.net/projects/libpng/files/zlib/1.2.11/zlib-1.2.11.tar.gz
tar –zxvf zlib-1.2.11.tar.gz
~~~

___

**download & unzip openssl**
~~~shell
cd /home/alic/dl
wget https://www.openssl.org/source/openssl-1.1.0b.tar.gz
tar –zxvf openssl-1.1.0b.tar.gz
~~~

___


**download & install nginx**
~~~shell
cd /home/alic/dl
wget http://nginx.org/download/nginx-1.12.2.tar.gz
tar –zxvf nginx-1.12.2.tar.gz
cd nginx-1.12.2

./configure --prefix=/home/alic/service/nginx-1.12.2 \
--sbin-path=/home/alic/service/nginx-1.12.2/sbin/nginx \
--conf-path=/home/alic/service/nginx-1.12.2/nginx.conf \
--pid-path=/home/alic/service/nginx-1.12.2/nginx.pid \
--user=www --group=www --with-http_ssl_module\
 --with-http_flv_module --with-http_mp4_module \
 --with-http_stub_status_module \
--with-select_module \
--with-poll_module \
--error-log-path=/home/alic/service/nginx-1.12.2/logs/error.log \
--http-log-path=/home/alic/service/nginx-1.12.2/logs/access.log \
 --with-pcre=/home/alic/dl/pcre-8.41 \
--with-zlib=/home/alic/dl/zlib-1.2.11 \
--with-openssl=/home/alic/dl/openssl-1.1.0b \
 --with-http_v2_module

make test
make
make install
~~~


>--prefix表示指定安装路径
--sbin-path表示nginx的可执行文件存放路径
--conf-path表示nginx的主配置文件存放路径，nginx允许使用不同的配置文件启动，通过命令行中的-c选项
--pid-path表示nginx.pid文件的存放路径，将存储的主进程的进程号。安装完成后，可以随时改变的文件名 ， 在nginx.conf配置文件中使用 PID指令。默认情况下，文件名 为prefix/logs/nginx.pid
--error-log-path表示nginx的主错误、警告、和诊断文件存放路径
--http-log-path表示nginx的主请求的HTTP服务器的日志文件的存放路径
--user表示nginx工作进程的用户
--group表示nginx工作进程的用户组
--with-select_module或--without-select_module表示启用或禁用构建一个模块来允许服务器使用select()方法
--with-poll_module或--without-poll_module表示启用或禁用构建一个模块来允许服务器使用poll()方法
--with-http_ssl_module表示使用https协议模块。默认情况下，该模块没有被构建。建立并运行此模块的OpenSSL库是必需的
--with-pcre表示pcre的源码路径
--with-zlib表示zlib的源码路径
--with-openssl表示openssl库的源码路径


__

**Create group and user**
~~~
groupadd www
useradd -M -g www -s /sbin/nologin www
~~~

**setting nginx configure**
~~~shell
[alic@samego nginx]$ mkdir  /home/alic/service/nginx/conf/vhosts -p
[alic@samego nginx]$ cat /home/alic/service/nginx/nginx.conf
# alicfeng user
user  alic;
worker_processes  2;

error_log  /home/alic/service/nginx/log/error.log;

pid        /home/alic/service/nginx/log/nginx.pid;


events {
	#alicfeng
	use epoll;
    worker_connections  1024;
}


http {
    include       mime.types;
    default_type  application/octet-stream;

    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';

	# alicfeng log
    access_log  /home/alic/service/nginx/log/access.log  main;

    sendfile        on;
    tcp_nopush     on;

    #keepalive_timeout  0;
    keepalive_timeout  65;

    gzip  on;

	server_names_hash_bucket_size 128;
	client_header_buffer_size 32k;
	large_client_header_buffers 4 32k;
	client_max_body_size 8m;

	fastcgi_connect_timeout 300;
	fastcgi_send_timeout 300;
	fastcgi_read_timeout 300;
	fastcgi_buffer_size 64k;
	fastcgi_buffers 4 64k;
	fastcgi_busy_buffers_size 128k;
	fastcgi_temp_file_write_size 128k;

	include /home/alic/service/nginx/conf/vhosts/*.conf;
}
~~~

**add system env path**
~~~shell
sudo vim /etc/profile

export NGINX_HOME=/home/alic/service/nginx
export PATH=$PATH:$NGINX_HOME/sbin

source /etc/profile
~~~

___

**add system service**
~~~shell
sudo touch  /etc/init.d/nginx
sudo chmod +x  /etc/init.d/nginx
sudo vim /etc/init.d/nginx


#!/bin/sh
# nginx - this script starts and stops the nginx daemin
#
# chkconfig:   - 85 15

# description:  Nginx is an HTTP(S) server, HTTP(S) reverse \
#               proxy and IMAP/POP3 proxy server

# processname: nginx
# config:      /home/alic/service/nginx/conf/nginx.conf
# pidfile:     /home/alic/service/nginx/log/nginx.pid

# Source function library.

. /etc/rc.d/init.d/functions

# Source networking configuration.

. /etc/sysconfig/network

# Check that networking is up.

[ "$NETWORKING" = "no" ] && exit 0

nginx="/home/alic/service/nginx/sbin/nginx"

prog=$(basename $nginx)

NGINX_CONF_FILE="/home/alic/service/nginx/conf/nginx.conf"

lockfile=/var/lock/subsys/nginx

start() {

    [ -x $nginx ] || exit 5

    [ -f $NGINX_CONF_FILE ] || exit 6

    echo -n $"Starting $prog: "

    daemon $nginx -c $NGINX_CONF_FILE

    retval=$?

    echo

    [ $retval -eq 0 ] && touch $lockfile

    return $retval

}


stop() {

    echo -n $"Stopping $prog: "

    killproc $prog -QUIT

    retval=$?

    echo

    [ $retval -eq 0 ] && rm -f $lockfile

    return $retval

}



restart() {

    configtest || return $?

    stop

    start

}


reload() {

    configtest || return $?

    echo -n $"Reloading $prog: "

    killproc $nginx -HUP

    RETVAL=$?

    echo

}

force_reload() {

    restart

}


configtest() {

  $nginx -t -c $NGINX_CONF_FILE

}



rh_status() {

    status $prog

}


rh_status_q() {

    rh_status >/dev/null 2>&1

}

case "$1" in

    start)

        rh_status_q && exit 0
        $1
        ;;

    stop)


        rh_status_q || exit 0
        $1
        ;;

    restart|configtest)
        $1
        ;;

    reload)
        rh_status_q || exit 7
        $1
        ;;


    force-reload)
        force_reload
        ;;
    status)
        rh_status
        ;;


    condrestart|try-restart)

        rh_status_q || exit 0
            ;;

    *)

        echo $"Usage: $0 {start|stop|status|restart|condrestart|try-restart|reload|force-reload|configtest}"
        exit 2

esac
~~~

__

**start nginx service**
~~~

~~~

___

**settting nginx auto start when os is starting**
~~~shell
sudo chkconfig --add nginx
sudo chkconfig nginx on
~~~












