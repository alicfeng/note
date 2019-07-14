---
title: Linux环境下使用C++编写CGI之安装cgicc模块
date: 2016-06-29
tags:
  - CGI
  - Linux
categories: Clang
---



**直接进入主题**

<!-- more -->

- Step-One：下载cgicc
 传送[cgicc下载地址](ftp://ftp.gnu.org/gnu/cgicc/)
___
Step-Two：编译安装
~~~shell
$ tar xzf cgicc-X.X.X.tar.gz(用最新版本)
$ cd cgicc-X.X.X
$ ./configure --prefix=/usr
$ make
$ sudo make install
~~~
___
至此已经安装完成~~~
___
Sameple
- file form.html
~~~html
<meta charset='utf-8'>
<form action="./cpp_get.cgi" method="get">
名：
<input type="text" name="first_name">  <br />
姓：
<input type="text" name="last_name" />
<br><br>
<input type="submit" value="提交" />
</form>
~~~
- cpp_get.cpp
~~~cpp
#include <iostream>
#include <vector>  
#include <string>  
#include <stdio.h>  
#include <stdlib.h> 
#include <cgicc/CgiDefs.h> 
#include <cgicc/Cgicc.h> 
#include <cgicc/HTTPHTMLHeader.h> 
#include <cgicc/HTMLClasses.h>  
using namespace std;
using namespace cgicc;
int main (){
   Cgicc formData;
   cout << "Content-type:text/html\r\n\r\n";
   cout << "<html>\n";
   cout << "<head>\n";
   cout << "<meta charset='utf-8'>\n";
   cout << "<title>使用 GET 和 POST 方法</title>\n";
   cout << "</head>\n";
   cout << "<body>\n";

   form_iterator fi = formData.getElement("first_name");  
   if( !fi->isEmpty() && fi != (*formData).end()) {  
      cout << "名：" << **fi << endl;  
   }else{
      cout << "No text entered for first name" << endl;  
   }
   cout << "<br/>\n";
   fi = formData.getElement("last_name");  
   if( !fi->isEmpty() &&fi != (*formData).end()) {  
      cout << "姓：" << **fi << endl;  
   }else{
      cout << "No text entered for last name" << endl;  
   }
   cout << "<br/>\n";
   cout << "</body>\n";
   cout << "</html>\n";
   return 0;
}
~~~
___
- 编译
~~~
$ g++ -o cpp_get.cgi cpp_get.cpp -lcgicc
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-61d2bcd446c076ae.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
