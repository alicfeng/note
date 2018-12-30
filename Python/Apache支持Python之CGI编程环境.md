**CGI简介**：CGI程序可以是Python脚本，Perl脚本，Shell脚本，C或者C++程序等
___
**环境说明**
- 操作系统 ：Ubuntu
- Web服务器：Apache2
- 开发语言：Python
___
**Step-One：加载cgi模块**
~~~
#默认apache2是没有加载cgi模块的
#在apache2/mods-enabled目录下创建cgi.load软链接
$cd /etc/apache2/mods-enabled && sudo ln -s ../mods-available/cgi.load cgi.load
~~~
___
**Step-Two：配置虚拟主机以及映射关系信息**
在/etc/apache2/sites-enabled/新建一个虚拟主机配置文件
~~~
<VirtualHost *:80>
	ServerAdmin webmaster@python.alic
	ServerName python.alic
	DocumentRoot /home/alic/WorkSpace/Python
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
~~~
在/etc/apache2/apache.conf/增加虚拟主机映射关系信息
~~~
#python
<Directory /home/alic/WorkSpace/Python/>
	AllowOverride None
        Options +ExecCGI
        Order allow,deny
        Allow from all
	AddHandler cgi-script .cgi .pl .py
</Directory>
~~~
___
**Step-Three：测试**
cgi程序代码
~~~
#!/usr/bin/python
# coding = utf-8
print "Content-type:text/html"
print  # 空行，告诉服务器结束头部
print '<html>'
print '<head>'
print '<meta charset="utf-8">'
print '<title>CGI | Alic</title>'
print '</head>'
print '<body>'
print '<h2>Hello WAlic</h2>'
print '</body>'
print '</html>'
~~~
给予cgi程序755权限
~~~
$sudo chmod 755  Demo01Web.py
~~~
浏览器测试
![浏览器测试](http://upload-images.jianshu.io/upload_images/1678789-6bfcae5708ce551e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

**价值源于技术，贡献源于分享**
