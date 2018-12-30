**sed简介**
sed 是一种在线编辑器，它一次处理一行内容。处理时，把当前处理的行存储在临时缓冲区中，称为“模式空间”（pattern space），接着用sed命令处理缓冲区中的内容，处理完成后，把缓冲区的内容送往屏幕。接着处理下一行，这样不断重复，直到文件末尾。文件内容并没有 改变，sed只是对缓冲区中原始文件的副本进行编辑，并不是编辑原始的文件。除非你使用重定向存储输出或者使用使用sed编辑命令中的w选项。Sed主要用来自动编辑一个或多个文件；简化对文件的反复操作。
___
**sed命令参数**
- a ：新增， a 的后面可以接字串，而这些字串会在新的一行出现(目前的下一行) 
- c ：取代， c 的后面可以接字串，这些字串可以取代 n1,n2 之间的行！
- d ：删除，因为是删除啊，所以 d 后面通常不接任何咚咚；
- i ：插入， i 的后面可以接字串，而这些字串会在新的一行出现(目前的上一行)；
- p ：列印，亦即将某个选择的数据印出。通常 p 会与参数 sed -n 一起运行
- s ：取代，可以直接进行取代的工作哩！通常这个 s 的动作可以搭配正规表示法！例如 1,20s/old/new/g 就是啦
___
不怎么喜欢理论行的东西，来来来，实践实践～～～
操作的文件为sedfile
- 在指定行添加行内容，比如在第三行添加"insertLine"内容
~~~
$sed -e 3a\insertLine sedfile
sed '2a insert' sedfile #在第三行后添加 即第三行开始
sed '2i insert' sedfile #在第二行前添加 即第二行开始
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-35921a0ef334addb.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 删除指定行内容，可以是一个范围的多行【1,2,3,4,5...$表示最后一行】
~~~
$sed -e '2,4d' sedfile #推荐
或者
$sed '2,4d' sedfile #没有-e也是可以的
#删除第二行
$sed '2d' sedfile
#要删除第 3 到最后一行
$sed '3,$d' sedfile
#注意 d表示删除然而 sed 后面接的是动作需要以单引号括起来
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-9af4b1a59b5d5cbe.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 以行为单位替换内容
~~~
$sed '2,5c 这是alic替换的content' sedfile #替换第二到第五行的内容
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-0a989f50d722a232.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- 以行为单位的显示
~~~
$sed -n '2,4p' sedfile #显示第二到第四行
$sed -n '二p' sedfile #搜索与二相关的行
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-936f51fb9aaa7a3f.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 内容的搜索并删除【以行为单位】
~~~
$sed '/二/d' sedfile #搜索到二相关的行并删除
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-c590df55af9d9e60.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
- 内容搜索并替换
~~~
$sed 's/alic/灿/g' sedfile #将alic替换成灿
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-31d502d16b7f8674.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- 多点处理
~~~
sed -e '3,4d' -e 's/alic/灿/g' sedfile #删除第三四行 而且同时将alic替换成灿
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-b135a66d33fc7509.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
Linux运维基础且常用命令
[Linux之crontab定时任务](http://www.jianshu.com/p/838db0269fd0)
[Linux之sed文本处理命令](http://www.jianshu.com/p/8269c36331ee)
[Linux之ps进程查看命令](http://www.jianshu.com/p/367276be1469)
[Linux之expect交互语言命令](http://www.jianshu.com/p/59f2e14e2535)
[Linux之tail命令](http://www.jianshu.com/p/168e8a01c2e2)
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
