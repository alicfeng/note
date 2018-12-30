前言：
 今晚又折腾一个晚上，想用C++语言开发web服务端，于是就再次配置apache2-cgi环境，万万没想到就是忘了C++需要编译才...,然而搞了一个小时的500-error-code，还以为服务器哪里还存在啥问题。先记录一下配置文件吧~~~
___

配置信息(主机映射信息与服务器项目读取路径写在一起了，实质上可以分开的)
~~~
<VirtualHost *:80>
    ServerName cgi.alic.com
    DocumentRoot /home/alic/www/cgi-bin/
    <Directory /home/alic/www/cgi-bin>
        Options +Indexes +FollowSymLinks +MultiViews +ExecCGI
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
    AddHandler cgi-script .py .cgi
</VirtualHost>
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
