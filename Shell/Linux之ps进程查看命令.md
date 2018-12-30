**前言**
嘿嘿，在linux服务器上作业，查看进程是必不可少的，那么个人还是推荐ps命令的，为什么呢？简单粗暴，功能强大！
___
ps命令参数
- -A ：所有的 process 均显示出来，与 -e 具有同样的效用；
- -a ：不与 terminal 有关的所有 process ；
- -u ：有效使用者 (effective user) 相关的 process ；
- x ：通常与 a 这个参数一起使用，可列出较完整资讯。输出格式规划：
- l ：较长、较详细的将该 PID 的的资讯列出；
- j ：工作的格式 (jobs format)-f ：做一个更为完整的输出。
___
最常用的就是混合使用，比如查找apache2进程
~~~
$ps aux | grep apache2
~~~
![alic-shell-iamge.png](http://upload-images.jianshu.io/upload_images/1678789-c28862dc87aef58a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
Linux运维基础且常用命令
[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
[Linux之sed文本处理命令](http://www.jianshu.com/p/8269c36331ee)
[Linux之ps进程查看命令](http://www.jianshu.com/p/367276be1469)
[Linux之expect交互语言命令](http://www.jianshu.com/p/59f2e14e2535)
[Linux之tail命令](http://www.jianshu.com/p/168e8a01c2e2)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
