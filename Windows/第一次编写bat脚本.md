** 前言 **
今天中午在宿舍不想做什么事，于是想到傻怡的电脑太卡了，多方面原因造成的，多软件安装于系统盘、安装了没用的杀毒软件等等，但是对于windows系统来说呢，使用时间长了，会有很多的缓存文件、日志文件等垃圾，同样样会造成电脑卡顿，突然就想到了bat批处理脚本来删除垃圾文件，玩了半小时搞出一个清理垃圾的exe，基于控制台运行。想想我差点忘了我还是有windows系统的，长期不关机差点给忘了。
___

** bat简介 **
一句话：bat批处理脚本主要应用于DOS和Windows操作系统，分别用另个系统中各自内嵌的命令解释器运行。
___

** bat使用基础 **
先来看一个最简单的bat，代码如下
```
@echo off
title 这是标题
color 03
mode con cols=40 lines=15
:: todo
echo hello world
pause
```

![运行结果](http://upload-images.jianshu.io/upload_images/1678789-277fc76f8ea591e7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

详细解释一下：
`@echo off`：指的是程序的开始，即程序的入口
`title`：指的是程序的标题
`color`：背景颜色以及字体颜色，它的值由两位十六进制的数组成，前面一位指的是背景颜色，后面一位指的是字体颜色。
`mode con cols=40 lines=15`：指的是窗口大小
`pause`：程序结束标记
____

** bat实例 **
删除系统盘里面所有的.tmp文件，即临时文件
```
del /f /s /q  %systemdrive%\*.tmp 1>nul 2>nul
```
在浏览器打开一个网站，比如百度
```
start http://www.baidu.com
```
备份数据库
```
mysqldump -uroot -p {$pwd} {$db} > {$filepath}
```
使用过后，bat感觉与shell同一个级别，但是我还是热衷于shell。
___
 
** bat 打包 exe **
bat虽然是基于cmd控制台运行，但是始终看到bat心里有点不舒服，强迫症吧，必须把bat转成exe程序执行。[converter](https://pan.baidu.com/s/1eSFtlwY)是将bat转成exe的一个工具。

![converter](http://upload-images.jianshu.io/upload_images/1678789-b17af571ac0b2376.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- batchfile：bat文件的路径
- Include：bat包含的文件
- Iconfile：应用图标
- Save as ：exe文件的保存路径，自动填充的
___

对于todo部分网络上有很多的资料，几乎想做什么就有什么，下面是一个清理windows系统垃圾的一个bat。
```
@echo off
:: 配置
title Alic Feng batTool for Clean
color 03
mode con cols=42 lines=20

echo executes cleaning,Please waiting...

::程序删除系统无用文件开始
del /f /s /q  %systemdrive%\*.tmp 1>nul 2>nul
del /f /s /q  %systemdrive%\*._mp 1>nul 2>nul
del /f /s /q  %systemdrive%\*.log 1>nul 2>nul
del /f /s /q  %systemdrive%\*.gid 1>nul 2>nul
del /f /s /q  %systemdrive%\*.chk 1>nul 2>nul
del /f /s /q  %systemdrive%\*.old 1>nul 2>nul
del /f /s /q  %systemdrive%\recycled\*.* 1>nul 2>nul
del /f /s /q  %windir%\*.bak 1>nul 2>nul
del /f /s /q  %windir%\prefetch\*.* 1>nul 2>nul
del /f /s /q %windir%\temp\*.* 1>nul 2>nul
del /f /q  %userprofile%\cookies\*.* 1>nul 2>nul
del /f /q  %userprofile%\recent\*.* 1>nul 2>nul
del /f /s /q  "%userprofile%\Local Settings\Temporary Internet Files\*.*" 1>nul 2>nul
del /f /s /q  "%userprofile%\Local Settings\Temp\*.*" 1>nul 2>nul
del /f /s /q  "%userprofile%\recent\*.*" 1>nul 2>nul
::程序删除系统无用文件开始

echo 清除系统完成
echo. & pause
```
远离Windows，靠近Unix/Linux，O(∩_∩)O哈哈~
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)** 
