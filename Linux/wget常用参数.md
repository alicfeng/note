**前言**
一句话：wget不仅功能强大，使用极其简单的。
___

**wget特性**
- 支持断点下传功能【important】
- 同时支持FTP和HTTP下载方式
- 支持代理服务器
- 设置方便简单
- 程序小，更是开源
___

**基本语法**

wget [参数列表] URL。
___

**常用参数**

1、简单wget
~~~
$wget http://www.example.com
~~~

2、递归下载 - 【下载整个网站资源】
~~~
$wget -r  http://www.example.com/
~~~

3、断点续传
~~~
$wget -c http://www.example.com/eos.iso
~~~

4、批量下载
如果有多个文件需要下载，那么可以生成一个文件，把每个文件的URL写一行，例如生成文件download
~~~
$wget -i download
~~~


5、选择性的下载
–accept=LIST 可以接受的文件类型，–reject=LIST拒绝接受的文件类型。
~~~
#忽略gif文件。
wget -m –reject=gif -r http://www.example.com/
~~~


6、密码和认证
wget只能处理利用用户名/密码方式限制访问的网站，可以利用两个参数：
~~~
–http-user=USER设置HTTP用户
–http-passwd=PASS设置HTTP密码
对于需要证书做认证的网站，就只能利用其他下载工具了，例如curl。
~~~

7、利用代理服务器进行下载
如果用户的网络需要经过代理服务器，那么可以让wget通过代理服务器进行文件的下载。此时需要在当前用户的目录下创建一个.wgetrc文件。文件中可以设置代理服务器：

~~~
http-proxy = 111.111.111.111:8080
ftp-proxy = 111.111.111.111:8080
#分别表示http的代理服务器和ftp的代理服务器。如果代理服务器需要密码则使用：
–proxy-user=USER设置代理用户
–proxy-passwd=PASS设置代理密码
~~~
使用参数–proxy=on/off 使用或者关闭代理。
___


**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
