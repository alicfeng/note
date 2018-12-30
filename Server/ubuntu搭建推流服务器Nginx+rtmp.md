**前言**
最近这两年直播平台及其流行，然而我呢？
也要玩玩推流服务器～～～
实现服务器推流/PC客户端观看/浏览器客户端查看
___
**简介**
对于Nginx的优点呢就不多说了，两句话：
1)并发量高
2)可负载均衡
重点谈谈rtmp吧！
RTMP全称是Real Time Messaging Protocol（实时消息传输协议），rmtp是一种通讯协议。该协议基于TCP，是一个协议族，包括RTMP基本协议及RTMPT/RTMPS/RTMPE等多种变种。RTMP是一种设计用来进行实时数据通信的网络协议，主要用来在Flash/AIR平台和支持RTMP协议的流媒体/交互服务器之间进行音视频和数据通信。现在更流行于直播平台服务器的推流处理！
___

**install搭建**
- 建立源码编译的目录
~~~
$ mkdir nginx-src
$ cd nginx-src
~~~

- 下载源码仓库
~~~
#nginx源码
$ git clone https://github.com/nginx/nginx.git
#nginx的rtmp模块源码
$ git clone https://github.com/arut/nginx-rtmp-module.git
#nginx的依赖pcre源码
$ wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.39.tar.gz
$ tar -xzvf pcre-8.39.tar.gz
$ cd nginx$ git checkout release-1.9.9
~~~

- 准备编译安装
~~~
#将configure的命令封装成脚本
$ vim cfg.sh
~~~
~~~
#  cfg.sh文件的内容
auto/configure --prefix=/usr/local/nginx \
		--with-pcre=../pcre-8.39 \
                --with-http_ssl_module \
                --with-http_v2_module \
                --with-http_flv_module \
                --with-http_mp4_module \
                --add-module=../nginx-rtmp-module/
~~~
~~~
$ chmod a+x cfg.sh
$ ./cfg.sh
$ make 
$ make install
~~~

- 启动nginx服务器
~~~
/usr/local/nginx/sbin/nginx
~~~
**配置nginx**
在nginx的配置文件nginx.conf最后添加如下信息
~~~
# RMTP的服务器配置信息
rtmp {
        server {
                listen  2016; #推流的监听端口
                publish_time_fix on;
                # 推流其一
                application live {
                        live on; #stream on live allow
                        allow publish all; # control access privilege
                        allow play all; # control access privilege
                }
               #推流其二
		application hls_alic {
                        live on;
                        hls on;
                        hls_path /home/alic/www/hls;
                        hls_fragment 5s;
                }
        }
}
~~~
重新加载nginx的配置
~~~
$ /usr/local/nginx/sbin/nginx -s reload
~~~

**简单的测试demo**
安装ffmpag
~~~
$ add-apt-repository ppa:kirillshkrogalev/ffmpeg-next
$ apt-get update
$  apt-get install ffmpeg
~~~
使用ffmpeg向服务器推送一个视频
~~~
ffmpeg -re -i /home/alic/Desktop/demo/film.mp4 -c copy -f flv rtmp://localhost:2016/live/film
or
# 推荐 可用于浏览器播放
ffmpeg -re -i /home/alic/Desktop/demo/film.mp4 -c copy -f flv rtmp://localhost:2016/hls_alic/film
~~~


![Alic_推流](http://upload-images.jianshu.io/upload_images/1678789-2ab6db5c53c16f2a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

视频播放器获取视频流
![Alic_客户端获取流](http://upload-images.jianshu.io/upload_images/1678789-53b7fc899ecdf6e7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

对于浏览器呢,html的整理代码如下
~~~
<html>
<head>
    <link rel="stylesheet" href="http://vjs.zencdn.net/5.10/video-js.css">
</head>
    <video id=example-video width=960 height=540 class="video-js vjs-default-skin" controls>
        <source
            src="film.m3u8"
            type="application/x-mpegURL">
    </video>
    <script src="http://vjs.zencdn.net/5.10/video.js"></script>
    <script src="https://npmcdn.com/videojs-contrib-hls@^3.0.0/dist/videojs-contrib-hls.js"></script>
    <script>
        var player = videojs('example-video');
        player.play();
    </script>
</html>
~~~
注意，在hls_path的路径添加一个站点来访问即可！
推流还是用ffmpeg的命令来, 推流一段时间后, 你会发现在"/home/alic/www/hls"目录里, 有很多ts文件,
还有一个后缀".m3u8"文件上面配置中的 server:8081 块, 就是为了能在外部能访问这些ts文件和m3u8文件。

![Alic_浏览器](http://upload-images.jianshu.io/upload_images/1678789-6888250cd9abfe34.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
搭建推流服务器Nginx+rtmp就成功了！
即将总结ffmpeg推流的命令~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
