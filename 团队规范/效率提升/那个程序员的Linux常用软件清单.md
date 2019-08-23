### 一、日常工具篇
**1.1、Google Chrome**
[Google Chrome](https://www.google.com/chrome/)是一个由Google公司开发的免费网页浏览器，其应用商店有众多出色的应用以及插件，此应用属于跨平台于Mac、Linux、Windows、Android等，因而数据的同步就okay了；此外它还拥有一个开源的兄弟Chromium。**强烈推荐**

![Google Chrome](http://upload-images.jianshu.io/upload_images/1678789-e1f450fab50adc18.png)

方法一：在官网下载对应版本的deb后执行
~~~
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
方法二：包管理apt-get安装
~~~
sudo apt-get install google-chrome-stable
~~~
>刚说了Google Chrome有众多的出色的插件，那还是得说几个我常用的
`AdBlock`：最受欢迎的Chrome扩展，拥有超过4000万用户！屏蔽整个互联网上的广告
`The QR Code Extension`：允许当前页面生成QR码，并使用网络摄像头扫描QR码。
`Window Resizer`：调节屏幕的分辨率，诸多时候用户开发
`Vimium`：vim的分身
`Proxy SwitchyOmega`：轻松快捷地管理和切换多个代理设置
`Wechat`：微信
`马克飞象`：使用印象笔记扩展程序一键保存精彩网页内容到印象笔记帐户
`惠惠购物助手`：【网易出品】在您网购浏览商品的同时，自动对比其他优质电商同款商品价格，并提供商品价格历史，帮您轻松抄底，聪明网购不吃亏
`JSON-handle`：顾名思义就是处理JSON数据的工具
... ...

___

**1.2、Firefox**
[Firefox](http://www.firefox.com.cn/)即火狐浏览器，它是一个安全高效且体积小的浏览器，它具有速度快、隐私保护、不同设备之间同步数据、个性化定制等特性，对于我来说呢，Firefox具有众多的开发插件。

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-c9bc860c3a69d41d.png)
~~~
sudo apt-get install firefox -y
~~~
___
**1.3、Gparted**
[GParted](http://gparted.org/)是一个分区工具，它可以用于创建、删除、移动分区，调整分区大小，检查、复制分区等操作。可以用于调整分区以安装新操作系统、备份特定分区到另一块硬盘等。

![GParted](http://upload-images.jianshu.io/upload_images/1678789-35df1b78a50b27af.png)

~~~
sudo apt-get install gparted -y
~~~
___

**1.4、搜狗输入法**
[搜狗输入法](http://pinyin.sogou.com/linux/?r=pinyin)顾名思义，它就是一个输入法。

![搜狗输入法](http://upload-images.jianshu.io/upload_images/1678789-8d9877d9112e3032.png)

~~~
#在官网下载deb后，执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___

**1.5、FileZilla**
[FileZilla](https://filezilla-project.org/)是一个免费开源的FTP软件，分为客户端版本和服务器版本，具备所有的FTP软件功能。可控性、有条理的界面和管理多站点的简化方式使得Filezilla客户端版成为一个方便高效的FTP客户端工具。

![FileZilla](http://upload-images.jianshu.io/upload_images/1678789-def291b922b1a08f.png)

~~~
sudo apt-get install filezilla
~~~
___
**1.6、WPS**
[WPS](http://www.wps.cn/)是由金山软件股份有限公司自主研发的一款办公软件套装，可以实现办公软件最常用的文字、表格、演示等多种功能。具有内存占用低、运行速度快、体积小巧、强大插件平台支持等特点。

![WPS](http://upload-images.jianshu.io/upload_images/1678789-a3d437156839db0d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

 ~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
>顺便路过提提[LibreOffice](https://zh-cn.libreoffice.org/) ，它也是是一款功能强大的办公套件，默认在ubuntu自带，强迫症看起来不舒服不使用。
___

**1.7、有道翻译**
[有道词典](http://www.youdao.com)是由网易有道出品的全球首款基于搜索引擎技术的全能免费语言翻译软件，为全年龄段学习人群提供优质顺畅的查词翻译服务。

![有道词典](http://upload-images.jianshu.io/upload_images/1678789-cadc9b801e8c7706.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

 ~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___
**1.8、网易云音乐**
[网易云音乐](http://music.163.com/)是一款专注于发现与分享的音乐产品,依托专业音乐人、DJ、好友推荐及社交功能,为用户打造全新的音乐生活。

![网易云音乐](http://upload-images.jianshu.io/upload_images/1678789-1d64ee4ea1d4918a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

 ~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
◾ 网易云音乐最小化托盘问题 ，解决方案：把原来的Exec那行改为
>Exec=env XDG_CURRENT_DESKTOP=Unity netease-cloud-music %U

___

**1.9、VLC**
[VLC](http://www.videolan.org/) 是一款自由、开源的跨平台多媒体播放器及框架，可播放大多数多媒体文件，以及 DVD、音频 CD、VCD 及各类流媒体协议。

![VLC](http://upload-images.jianshu.io/upload_images/1678789-c267981da96d5c84.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install vlc -y
~~~
>附带暗转媒体解码框架

~~~
sudo apt-add-repository ppa:mc3man/trusty-media
sudo apt-get update
sudo apt-get install Ubuntu-restricted-extras ffmpeg gstreamer0.10-plugins-ugly libavcodec-extra-54 libvdpau-va-gl1 libmad0 mpg321 gstreamer1.0-libav
~~~
___

**1.10、Kazam**
[Kazam](http://www.kazam.mobi/) 是 Ubuntu 上一款简易的桌面屏幕录制工具，它只能录制整个屏幕，可以录制声音，并可以快速上传录制好的视频到 YouTube 及 VideoBin 视频分享网站上。

![Kazam](http://upload-images.jianshu.io/upload_images/1678789-c78fa49d58293323.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:and471/kazam-daily-builds 
sudo apt-get update 
sudo apt-get install kazam
~~~
___


**1.11、Silentcast**
[Silentcast](https://github.com/colinkeenan/silentcast)是一款专注于GIF录制工具。

![Silentcast](http://upload-images.jianshu.io/upload_images/1678789-df11966b9a975747.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:sethj/silentcast
sudo apt-get update
sudo apt-get install silentcast
~~~
___

**1.12、Smplayer**
[Smplayer](http://smplayer.sourceforge.net)是一款开源的跨平台软件，其在Linux、Windows系统中有重要地位，影音播放能力很强大。

![Smplayer](http://upload-images.jianshu.io/upload_images/1678789-97d1a13282e30d54.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install smplayer
~~~
___


**1.13、Audience**
[Audience](http://design.ubuntu.com/audiences)是一款简洁而强大的视频播放器，怎么说呢：简洁到不能再简洁。它是ElementaryOS系统默认的视频播放器，强烈推荐！

![Audience](http://upload-images.jianshu.io/upload_images/1678789-cc11e45e7072db35.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install audience
~~~
___

**1.14、Gimp**
[Gimp](https://www.gimp.org)是一个图片编辑器，优雅地取代windows、mac下的另一个ps软件。

![Gimp](http://upload-images.jianshu.io/upload_images/1678789-4dca87a18d197bb6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:otto-kesselgulasch/gimp
sudo apt-get install gimp
~~~
___

**1.15、Krita**
[Krita]()是一个位图形编辑软件，包含一个绘画程式和照片编辑器。Krita是开源软件软件，Krita和gimp是有很大区别的，一句通俗的言语来表名：gimp是编辑图像用的，krita是画画用的。

![Krita](http://upload-images.jianshu.io/upload_images/1678789-3c551749859c4f12.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:kubuntu-ppa/backports
sudo apt-get install kdelibs-bin kbuildsycoca4 --noincremental krita -y
~~~
___
**1.16、gedit**
[gedit](https://gedit.en.softonic.com/)是一个基于GNOME桌面环境下兼容UTF-8的文本编辑器。它使用GTK+编写而成，因此它十分的简单易用，有良好的语法高亮，对中文支持很好，支持包括gb2312、gbk在内的多种字符编码。甚至你可以配置成用于开发的IDEA，我才不折腾这个呢。

![gedit](http://upload-images.jianshu.io/upload_images/1678789-01cd68387d0b13da.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install gedit
~~~
我还是经常习惯使用ElementaryOS自带的scratch-text-editor编辑器，不过它在ElementaryOS中使用搜狗输入法有一个bug：就是在非root下不能输入中文。
解决方案：
~~~
#将原来的
Exec=scratch-text-editor %U
X-GNOME-Gettext-Domain=scratch-text-editor
#改成如下
Exec=env GTK_IM_MODULE=xim scratch-text-editor %U
X-GNOME-Gettext-Domain=env GTK_IM_MODULE=xim scratch-text-editor
~~~
>既然讲到了文本编辑器，肯定少不了vim，接触过linux的几乎都认识这家伙,我也不多说。
[*Vim*最少必要知识](http://www.jianshu.com/p/881a168d454a)

___

**1.17、x11vnc客户端**
[x11vnc](http://design.ubuntu.com/audiences)是一种 位图显示的 视窗系统 。它是在 Unix 和 类Unix 操作系统 ，以及 OpenVMS 上建立图形用户界面的标准工具包和协议。x11vnc服务端可以实现Windows远程Linux桌面系统。

![X11vnc-server](http://upload-images.jianshu.io/upload_images/1678789-c660087c3b58ae61.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install x11vnc
~~~
___

**1.18、Shadowsocks-qt5**
[Shadowsocks-qt5](https://github.com/shadowsocks/shadowsocks-qt5)是一个科学上网利器工具。在天朝莫谈国情，说说Shadowsocks原理就好，它是将原来 ssh 创建的 Socks5 协议拆开成 Server 端和 Client 端，两个端分别安装在境外服务器和境内设备上。

![Shadowsocks-qt5](http://upload-images.jianshu.io/upload_images/1678789-9fafbe3453c332bb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


~~~
sudo add-apt-repository ppa:hzwhuang/ss-qt5
sudo apt-get update
sudo apt-get install shadowsocks-qt5 -y
~~~
___

**1.19、VirtualBox**
[VirtualBox](https://www.virtualbox.org)是一款由德国 Innotek 公司开发的开源虚拟机软件。号称是最强的免费虚拟机软件，它不仅具有丰富的特色以及轻量级的体积，而且性能也很优异！可虚拟的系统包括所有的Windows系统、Mac OS X、Linux、OpenBSD、Solaris、IBM OS2甚至Android等操作系统！为了完整地使用VirtualBox，尽量安装VirtualBox Extension Pack。

![VirtualBox](http://upload-images.jianshu.io/upload_images/1678789-812055590d4edf33.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

 ~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___

**1.20、Steam**
Steam是一个整合游戏下载平台，很少玩游戏也不多少了#_#

![Steam](http://upload-images.jianshu.io/upload_images/1678789-f57bada6e5b64743.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install steam
~~~
___
**1.21、electronic-wechat**
[electronic-wechat](https://github.com/geeeeeeeeek/electronic-wechat)是一个基于nodeJS开发的Linux系统微信。

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-edcec7f36feaa6c3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
git clone https://github.com/geeeeeeeeek/electronic-wechat.git
cd electronic-wechat
npm install && npm start
~~~
附上THis
微信之外最优选！纯净安全的聊天工具 – Telegram #iOS #Android #WP #Linux
```shell
sudo add-apt-repository ppa:atareao/telegram
sudo apt-get update
sudo apt-get install telegram
```
___

**1.22、Skype**
Skype 是一款即时通讯软件，具备视频聊天、多人语音会议、传送文件、文字聊天等功能。它允许用户进行跨平台的视频呼叫，可与使用电脑、手机、电视、PSV 等多种终端的 Skype 用户进行视频通话。

![Skype](http://upload-images.jianshu.io/upload_images/1678789-b0388463ca25bc01.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___
**1.23、 Transmission**
Transmission 是一个 BitTorrent 客户端软件，它支持速度限制、制作种子、远程控制、磁力链接、数据加密、损坏修复、数据来源交换等功能。

![Transmission](http://upload-images.jianshu.io/upload_images/1678789-c94b08ed736ed441.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install transmission
~~~
___
**1.24、 thunderbird**
thunderbird是又是一个简洁易用的邮箱客户端。

![thunderbird](http://upload-images.jianshu.io/upload_images/1678789-65be51178fddf244.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install thunderbird
~~~
___

**1.25、XMind**
XMind是一款实用的思维导图软件,简单易用、美观、功能强大,拥有高效的可视化思维模式,具备可扩展、跨平台。但是对于稳定性和性能还是欠佳，在ubuntu上使用占用很大的CPU资源。

![XMind](http://upload-images.jianshu.io/upload_images/1678789-a2e952baf5c35023.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___

**1.26、Okular**
Okular 是一个 PDF 文档阅读软件，支持 PDF、TIFF、CHM、ODF、EPUB、mobi 等文档格式。

![Okular](http://upload-images.jianshu.io/upload_images/1678789-5bfb907460eac636.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt install okular -y
~~~
___

**1.27、FocusWriter**
FocusWriter 是一款写作软件，为了让您的写作空间尽可能的多且不受打扰，FocusWriter 将几乎所有的工具栏都自动隐藏在屏幕边缘。利用 FocusWriter 写作便利流畅，您还可以设置闹钟和每日任务，非常适合撰稿人、小说写手、剧本作家使用。左蓝推荐！

![FocusWriter](http://upload-images.jianshu.io/upload_images/1678789-f0ddc562e059761a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt install focuswriter
~~~
___

**1.28、Typora**
[Typora](http://www.typora.io/)是极简的Markdown编辑器，合并了写作和预览。支持表格、代码编辑，拖拽插图等，非常好用；喜欢它的原因也就是：美观、免费。

![Typora](http://upload-images.jianshu.io/upload_images/1678789-eb1928603a9c7a45.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


~~~
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys BA300B7755AFCFAE
sudo add-apt-repository 'deb https://typora.io linux/'
sudo apt-get update
sudo apt-get install typora
~~~
___

**1.29、OBS Studio**
[OBS Studio](http://www.obsapp.net/) 是一款跨平台的，开源的视频录制和在线直播客户端软件。我觉得一点不好的体验就是不能刻录整个屏幕。[ymengyue推荐](http://www.jianshu.com/u/e4026cb2f05a)

![OBS Studio](http://upload-images.jianshu.io/upload_images/1678789-257427534695fed8.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install ffmpeg
sudo add-apt-repository ppa:obsproject/obs-studio
sudo apt-get update && sudo apt-get install obs-studio
~~~
[其他系统安装查看](https://github.com/jp9000/obs-studio/wiki/Install-Instructions#linux)
___
**1.30、Pencil**
[Pencil](http://pencil.evolus.vn)是一款开源的原型图绘制工具，手绘风格的，就像自己在纸上画的那样。还可以用来绘制各种架构图和流程图，同时还提供 Firefox 的插件。对于经常做设计的人来说是一个不错的软件，可谓是linux下的visio。


![Pencil](http://upload-images.jianshu.io/upload_images/1678789-86b4c3f915ec8489.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

```
wget -c http://pencil.evolus.vn/dl/V3.0.1/Pencil_3.0.1_i386.deb
sudo dpkg -i Pencil_3.0.1_i386.deb  
```
___
**1.31、Remmina**
Remmina是一个用远程桌面软件，提供了RDP、VNC、XDMCP、SSH等远程连接协议的支持。这个客户端最大的优点在于界面清爽，方便易用，创建远程连接的界面与Windows自带的远程桌面十分相近。可以到Linux软件管理器中搜索下载安装，十分方便．

![Remmina](http://upload-images.jianshu.io/upload_images/1678789-f38d8ae7d2535c58.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

```
sudo apt-get install remmina
```
___
**1.32、Meld**
Meld是针对开发者的视觉差异和合并工具。MELD帮助您比较文件、目录和版本控制的项目。它提供了两个和三个比较的文件和目录，并支持许多流行的版本控制系统。既可以查看差异有可以同步！


![Meld](http://upload-images.jianshu.io/upload_images/1678789-b9b961bc52d36af6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

```
sudo apt-get install meld
```
####二、系统工具篇
___
**2.1、deepin-scrot**
deepin-scrot是深度团队开发的一个截图工具。在deepin深度系统作为默认的截图软件，在debian系统安装需要在终端命令使用，为了方便推荐定义快捷键配合使用。强烈推荐！

~~~
#安装
wget http://packages.linuxdeepin.com/deepin/pool/main/d/deepin-scrot/deepin-scrot_2.0-0deepin_all.deb
sudo dpkg -i deepin-scrot_2.0-0deepin_all.deb
sudo apt-get install -f
#使用
deepin-scrot
~~~
___

**2.2、Albert Spotlight**
Albert Spotlight是 Ubuntu的一项快速、随打即找、系统支援的桌面搜寻特色。spotlight 被设计为可以找到任何位于电脑中广泛的项目，包含文件、图片、音乐、应用程式、系统喜好设定控制台，也可以是文件或是PDF中指定的字。优雅地取代了Mac中的mac Spotlight。

![Albert Spotlight*](http://upload-images.jianshu.io/upload_images/1678789-deac3970c12ac4fb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~~
sudo add-apt-repository ppa:noobslab/macbuntu
sudo apt-get update
sudo apt-get install albert
~~~~
___

**2.3、Guake Terminal**
[Guake](http://guake.org/)是一个下拉式的gnome桌面环境下的终端程序，因此你只需要按一个键就可以调用他，然后再按一次以便隐藏他。Guake支持快捷键、标签、背景透明等特性。一句话：GuakeTerminal是linux下完美帅气的终端！

![Guake Terminal](http://upload-images.jianshu.io/upload_images/1678789-85f49e1266493202.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

```shell
sudo add-apt-repository ppa:webupd8team/unstable
sudo apt-get update
sudo apt-get install guake
```


**2.4、bleachbit**
[bleachbit]()是系统ubuntu系统减肥的一门"中药"，用于清理系统没用的垃圾文件。

![bleachbit](http://upload-images.jianshu.io/upload_images/1678789-9655c761c92c8e2a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:n-muench/programs-ppa
sudo apt-get update
sudo apt-get install bleachbit -y
~~~
___

**2.5、psensor**
[psensor]()是监控系统硬件实时状况的一款软件，使用psensor可视化显示系统温度，需要基于lm-sensors和hddtemp等获得的数据。因此你需要在安装psensor的同时，一并安装这两款工具。

![psensor](http://upload-images.jianshu.io/upload_images/1678789-17038a3659511c81.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:jfi/ppa
sudo apt-get update
sudo apt-get install lm-sensors hddtemp psensor -y
~~~
___

**2.6、Indicator Netspeed**
Indicator Netspeed是一款基于Unity的用于显示软件上传和下载网络流量的软件。

![Indicator Netspeed](http://upload-images.jianshu.io/upload_images/1678789-8c489775c6edbef3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:nilarimogard/webupd8
sudo apt-get update
sudo apt-get install indicator-netspeed
~~~
___

**2.7、gnome-system-monitor**
[gnome-system-monito]()是一款基于GNOME桌面的系统监视器软件。不过使用它有点占内存，我还是习惯终端处理。

![gnome-system-monitor](http://upload-images.jianshu.io/upload_images/1678789-c49f4d16fed0b030.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install gnome-system-monitor
~~~
___

**2.8、catfish**
catfish简称文件搜索神器。

![catfish](http://upload-images.jianshu.io/upload_images/1678789-8168e976df355c61.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get instal catfish
~~~
___

**2.9、docky**
[dockey]()是一款一个号称花钱也买不到的菜单启动器。为什么这麽说的？很简单：它是开源的，很简洁更美观。就连Mac下的docky都是模仿它的，O(∩_∩)O哈哈~，不要傻了，开玩笑的。

![docky](http://upload-images.jianshu.io/upload_images/1678789-43deb569a623b9c7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install docky
~~~
___

**2.10、TLP**
TLP 是一款Linux流行的电源工具软件。你可以使用TLP来调整系统电池，有助于有更好延长电池寿命。

![TLP](http://upload-images.jianshu.io/upload_images/1678789-a4fd133b3d58ca15.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:linrunner/tlp
sudo apt-get update
sudo apt-get install tlp tlp-rdw
sudo tlp start
~~~
___
**2.11、menulibre**
[menulibre](https://launchpad.net/menulibre)是一个简洁易用的菜单编辑器。

![menulibre](http://upload-images.jianshu.io/upload_images/1678789-1abf6cf5bc64457a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:menulibre-dev/devel
sudo apt-get update
sudo apt-get install menulibre
~~~
___
**2.12、indicator-sysmonitor**

indicator-sysmonitor是一个系统动态信息监控工具。可以实时查看电脑的cpu，内存占用率，更可以查看网速，非常方便

![indicator-sysmonitor](http://upload-images.jianshu.io/upload_images/1678789-fd7ed5119b00c0ff.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

```
sudo add-apt-repository ppa:fossfreedom/indicator-sysmonitor 
sudo apt-get update  
sudo apt-get install indicator-sysmonitor  
```

####三、开发工具篇
___

**3.1、Jetbrains 全家桶**
[Jetbrains_IDEA](https://www.jetbrains.com) 全家桶基基于java语言开的一个工具套餐，而且基本覆盖了主流的开发编程语言，还包含了开发ios/macOS的工具。Jetbrains_IDEA包含了哪些工具呢，看图、手累截图！

![Jetbrains 全家桶](http://upload-images.jianshu.io/upload_images/1678789-940879e8cbbb3d44.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

**3.2、Brackets**
Brackets是一款使用 HTML，CSS，JavaScript 创建的开源的针对 Web 开发的编辑器。它具有什么优秀的特性的呢：实时预览，快速编辑，跨平台，可扩展，开源，Brackets是一款非常优秀的编辑器，但是我就是不用它O(∩_∩)O哈哈~。

![Brackets](http://upload-images.jianshu.io/upload_images/1678789-a6f27b4b37d3138e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
#天朝问题，漫长的等待，推荐下载安装
sudo add-apt-repository ppa:webupd8team/brackets
sudo apt-get update
sudo apt-get install brackets
sudo add-apt-repository -r ppa:webupd8team/brackets
~~~
___

**3.3、Android Studio**

[Android Studio](http://www.android-studio.org/)是啥我也就不说了，怕挨揍\(^o^)/~用来开发安卓的~~~

![Android Studio](http://upload-images.jianshu.io/upload_images/1678789-8337c7db484e9bfd.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

>顺手推荐几个网站
[镜像源androiddevtools](http://www.androiddevtools.cn/)
[开源库codekk](http://www.androiddevtools.cn/)

___

**3.4、Sublime Text**
[Sublime Text](https://www.sublimetext.com)是一个轻量、简洁、高效、跨平台的编辑器。不能再多解释了，只能简单说说它的优点：
- 可以编辑诸多主流的编程语言
- 语法高亮、代码提示补全、代码折叠、自定义皮肤/配色方案、多便签
- 代码地图、多种界面布局与全屏免打扰模式
- 完全开放的用户自定义配置与神奇实用的编辑状态恢复功能
- 雷电般快速的文件切换
- 随心所欲的跳转：快速罗列与定位函数/HTML的元素、跳转到指定行
- 集所有功能于一身的命令面板
- Package Contro扩展包管理器

![Sublime Text](http://upload-images.jianshu.io/upload_images/1678789-84a32e344eb3a20c.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**3.5、Atom**
[Atom](https://atom-china.org/)是GitHub推出的一款基于Web技术开发的桌面端的编辑器，其主要的特点是现代, 易用, 可定制。`被称为21世纪的黑客编辑器`我就笑笑O(∩_∩)O哈哈~

![Atom](http://upload-images.jianshu.io/upload_images/1678789-3fa3c7cbd01c61bd.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo add-apt-repository ppa:webupd8team/atom  
sudo apt-get update  
sudo apt-get install atom 
~~~

___


**3.6、sqliteman**
[sqliteman]()是一款小巧的图形化管理SQLite数据库的软件。轻量级、小巧、功能全面。为它点个赞，推荐！

![sqliteman](http://upload-images.jianshu.io/upload_images/1678789-7be08a726dca19a0.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install sqliteman
~~~
___

**3.7、Git、GitG**
[Git](https://git-scm.com)是一个开源的分布式版本控制系统，可以有效、高速的处理从很小到非常大的项目版本管理。简而言之就是代码管理工具，[常用Git命令记录](http://www.jianshu.com/p/fa03ebcde0a1)。既然提到了Git，那么也要说说它的朋友SVN，同样它俩的性质是一样的不必多说，[SVN的安装与基本使用](http://www.jianshu.com/p/af30d2f11c43)

~~~
sudo apt-get install git
~~~

gitg是一个用于查看Git版本控制系统的工具，基于Gnome桌面环境。我还是习惯在终端干这些活。

![Git](http://upload-images.jianshu.io/upload_images/1678789-5d7fa09ea9dfa260.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install gitg
~~~
___

**3.8、MySQL workbench**
[MySQL workbench](https://www.mysql.com/products/workbench)是一款专为MySQL设计的ER/数据库建模工具,但是在ElementaryOS还是存在不少的问题的。

![MySQL workbench](http://upload-images.jianshu.io/upload_images/1678789-431197d97f8633b8.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
#在官网下载对应版本的deb后执行
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___

**3.9、monodevelop**
MonoDevelop 是个适用于Linux、Mac和Windows的开放源代码集成开发环境，目前支持的语言有Python、Vala、C#、Java、BOO、Nemerle、Visual Basic .NET、CIL、C与C++。

![monodevelop](http://upload-images.jianshu.io/upload_images/1678789-68ccc17ae24eaeee.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install monodevelop  g++ xterm -y
~~~
___
**3.9、Genymotion**
[Genymotion](http://www.genymotion.net/)是一套完整的工具，它提供了Android虚拟环境，支持Windows、Linux和Mac OS等操作系统，容易安装和使用。开发安卓选择Genymotion模拟器是最佳的选择，除非你使用真机，其实后来我就是选择真机的——笑:-D。

![Genymotion](http://upload-images.jianshu.io/upload_images/1678789-4662f1cc64db3013.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
#在官网下载对应版本的deb后执行 ,需要注册后才能下载
sudo dpkg -i *.deb && sudo apt-get install -fy
~~~
___

**3.10、Android Screen Monitor**
[Android Screen Monitor](https://code.google.com/archive/p/android-screen-monitor)简称ASM，是一款监视手机或者模拟器屏幕的工具。

![Android Screen Monitor](http://upload-images.jianshu.io/upload_images/1678789-a2e81ef52708bc28.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
>时光机传送[安装与使用教程](https://code.google.com/archive/p/android-screen-monitor/)

___

####四、Terminal Tools
___
**4.1、enca、iconv**

enca、iconv都是文件编码转换工具。
~~~
#安装
sudo apt-get enca iconv
~~~
>简单使用

~~~
#enca查看文件编码
enca filename
#iconv将一个GBK编码的文件转换成UTF-8编码
enconv -L zh_CN -x UTF-8 filename
~~~
___

**4.2、Figlet**
一句话：Figlet是一个将字符串在终端生成一个logo的终端工具。

![Figlet](http://upload-images.jianshu.io/upload_images/1678789-d3203599e31fe989.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install figlet
~~~
___

**4.3、oh-my-zsh**
[oh-my-zsh](https://github.com/robbyrussell/oh-my-zsh)是终极Shell，就这么一句话！

![oh-my-zsh](http://upload-images.jianshu.io/upload_images/1678789-232d57bbd9678d3a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

~~~
sudo apt-get install git -y
wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | sh
~~~
>zsh的配置文件位于用户目录/home/$USER/.zshrc，**[zsh主题](https://github.com/robbyrussell/oh-my-zsh/wiki/themes)**，我的配置文件部分如下：

~~~
# oh-my-zsh的安装路径
export ZSH=/home/alic/.oh-my-zsh

# 主题设置
ZSH_THEME="robbyrussell"

# 大小写是否敏感
CASE_SENSITIVE="false"

# 连字符敏感
HYPHEN_INSENSITIVE="true"

# zsh是否自动不更新
DISABLE_AUTO_UPDATE="true"

plugins=(git)

source $ZSH/oh-my-zsh.sh

# 语言环境
export LANG=en_US.UTF-8
~~~
___

**4.4、Asciinema**
[Asciinema](https://asciinema.org/docs/getting-started) 是一个用 ClojureScript 编写的开源命令行录屏工具。对于详细的终端刻录工具可以查看[Linux 终端录制工具](http://www.jianshu.com/p/6e8fb918a55c)。

~~~
sudo apt-add-repository ppa:zanchey/asciinema
sudo apt-get update
sudo apt-get install asciinema
~~~
- 录制使用
~~~
asciinema rec
~~~
使用 exit 或者 Ctrl+D快捷键结束录制。它会在结束录制的时候提示，如果要上传的话，敲回车。上传之后，Asciinema 会给出一个网址。
~~~
#想嵌入网页
<script type="text/javascript" src="https://asciinema.org/a/2xcuc0651qtirbj8dkmmtf2nf.js" id="asciicast-https://asciinema.org/a/2xcuc0651qtirbj8dkmmtf2nf" async></script>
~~~
___

**4.5、Aria2**
[aria2](http://aria2.sourceforge.net/)是 Linux 下一个命令行下轻量级、多协议、多来源的高速下载工具。
~~~
sudo apt-get install aria2
~~~
>使用说明

~~~
#简单使用：只需要加上下载链接即可
aria2c ${link}
#分段下载
aria2c -s 2 ${link}
~~~
>Aria2 在百度云环境可以不限速下载，传送[Aria2 - 可能是现在下载百度云资料速度最快的方式](http://www.jianshu.com/p/e5e56a1d25a3)
___

**4.6、Proxychains4**
Proxychains4是一个终端挂代理的工具，可自由切换代理。使用简单只需要在命令前加上proxychains4即可！

~~~
git clone https://github.com/rofl0r/proxychains-ng.git
cd proxychains-ng
sudo ./configure –prefix=/usr –sysconfdir=/etc
sudo make && sudo make install && sudo make install-config
cd .. && rm -rf proxychains-ng
~~~

>配置文件位于`/usr/local/etc/proxychains.conf`
将socks4 127.0.0.1 9095改为 socks5  127.0.0.1 ${port} {$user} ${pwd}

___
**4.7、Ubuntu Make**
Ubuntu Make 原名 Ubuntu Developer Tools Center，是一款开源的命令行工具软件，主要是针对开发者，它可以安装大量的开发工具。

~~~
sudo add-apt-repository ppa:ubuntu-desktop/ubuntu-make
sudo apt-get update
sudo apt-get install ubuntu-make
~~~
比如安装Webstorm
~~~
sudo umake ide webstorm
~~~
___
**4.8、sshfs**
SSHFS最炫的地方在于可在本地安装的文件系统中，通过SSH获得所有加密的通信优势。sshfs 是基于 FUSE构建的 SSH 文件系统客户端程序，通过它远程主机的配置无需作任何改变，就可以透过 SSH 协议来挂载远程文件系统了，非常方便及安全。

~~~shell
sudo apt-get install sshfs
~~~
___
**4.8、字体**
喜欢锐利清晰字体的 Ubuntu 用户，可以安装文泉驿正黑
~~~shell
sudo apt-get install fonts-wqy-zenhei
~~~










___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
