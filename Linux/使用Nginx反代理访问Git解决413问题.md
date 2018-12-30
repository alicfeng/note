前言：记得在学期初的时候使用git就遇到了413，那时的git平台是我大哥搭建的，push比较大的文件的时候就会出现http回应413代码，但是直接使用Gogs服务器取代nginx服务器域名可以暂时解决该问题，于是乎我就理了，然而今天我又遇到了此问题，强迫症+不甘心=需要详谈。
___
环境：Gogs+Nginx+Git
___
**413的问题简况**
```
git push origin master  ＃执行提交
```
push提交的结果如下图
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-701cb966cac394b7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**413简况分析**
当通过Gogs自带的服务器使用git的话，是不会出现该问题的，因此只有只有域名才并且push大文件才会出现413，我是利用Nginx绑定域名反代理到学校服务器内网的PC主机的，那就是说：既然Gogs没有问题的话，那就是Nginx服务器的问题。由于我一直使用的是apache搭建服务器，对Nginx的环境不是那么熟悉，最近使用Nginx的目的就是因为它有反代理的功能。
简单的来说，使用git来访问nginx反代理到内网的服务器，上传大文件会返回413错误代码，因此可以理论上判断：nginx限制了对文件上传的大小。
___
**解决Git 413方法**
解决方法很简单，那就是修改nginx服务器的配置
```shell
sudo cp /etc/nginx/nginx.conf  /etc/nginx/nginx.conf.bak #备份文件
sudo nano /etc/nginx/nginx.conf    #修改nginx服务器的配置
```
添加一下一个配置信息
```shell
 client_max_body_size 50m;#客户端上传文件最大限制，默认是1m
```
然后重启nginx即可！
```shell
sudo service nginx reload
```
___
**git 413错误引导**
我查看了网络挺多的资料，很多人都回答是git配置的问题
比如http.postBuffer配置的问题
```shell
git config --global http.postBuffer 524288000  #git使用http协议提交的文件限制大小
```
其实这并非413错误代码，而是411的错误代码所需的配置。
___














