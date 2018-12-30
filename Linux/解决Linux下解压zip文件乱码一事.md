**前言**
在Linux下解压Window下的zip文件时，然而会经常出现乱码问题。原因很简单：在windows下压缩文件时，是以系统的默认GBK编码来压缩；同理：Linux下解压缩时，也会使用系统默认的UTF-8编码来解压。

___

**解决方案**
~~~
#CP936 -> GBK
$ unzip -O CP936 file.zip
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
