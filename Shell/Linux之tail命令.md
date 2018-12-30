前言：最近经常查看服务器的各种日志，然而对tail这个命令熟悉了，就此做一下笔记咯~~~
___
**命令格式**
tail[必要参数][选择参数][文件]   
___
**命令功能**
用于显示指定文件末尾内容，不指定文件时，作为输入信息进行处理。常用查看日志文件。
___
**命令参数**
-f 循环读取
-q 不显示处理信息
-v 显示详细的处理信息
-c<数目> 显示的字节数
-n<行数> 显示行数
--pid=PID 与-f合用,表示在进程ID,PID死掉之后结束. 
-q, --quiet, --silent 从不输出给出文件名的首部 
-s, --sleep-interval=S 与-f合用,表示在每次反复的间隔休眠S秒 
___
打印文件的内容【与cat filename命令一样】
~~~
$tail fileName
~~~
打印文件从第10行开始
~~~
$tail -n +10 fileName
~~~
打印文件后10行
~~~
$tail -n 10 fileName
~~~
实时打印文件内容【监控最常用】
~~~
$tail -f fileName.log
~~~
___
Linux运维基础且常用命令
[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
[Linux之sed文本处理命令](http://www.jianshu.com/p/8269c36331ee)
[Linux之ps进程查看命令](http://www.jianshu.com/p/367276be1469)
[Linux之expect交互语言命令](http://www.jianshu.com/p/59f2e14e2535)
[Linux之tail命令](http://www.jianshu.com/p/168e8a01c2e2)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
