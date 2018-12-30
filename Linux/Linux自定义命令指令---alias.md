前言：自从与Linux打交道之和，使用命令行是必然的，但是有些命令行很长或者有其他不便之处，之前呢，我是自己写一个shell脚本集成自己常用的命令，但是我也了解了alias，这也是挺不错的，不仅仅可以提高效率，还可以自定义很简洁的命令，还是蛮喜欢的。
___
**配置文件说明**
~~~
./bashrc #仅当前用户有效
~~~
~~~
/etc/bashrc #所有的用户都有效
~~~
___
**alias基本语法**
~~~
alias [自定义命令]=[原生命令或其组合]  #添加自定义的命令
~~~
___
**获取当前用户的命令**
~~~
alias #打开终端输入alias
~~~
___
**使配置文件生效**
~~~
source .bashrc#让我们的环境生效
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-7af13c859fc49821.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
如上简单配置即可！但是配置好后，我发觉在这么多行代码的文件上还添加自己的代码总是觉得不舒服，干嘛不自己另外引入自己的配置文件呢，修改方便，又简洁舒服。能想到的非常可能是有的，往下看我就看到了这样的说明
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-9f9055b067414586.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
嘿，说明了系统另外为用户自定义了加载一个用户的自定义文件.bashrc_aliases。
