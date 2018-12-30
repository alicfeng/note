前言：对于代码的托管与协作，我一般使用的是git，但是公司偏偏使用的是svn，好吧，为此同时，利用了GO语言开且开源的gogs项目[GIT]，，感觉还可以，But，还是svn，并非我说了算，于是我也只好svn啦，好吧开始了～～～
___
svn客户端的安装
~~~
#svn的安装很简单，一条命令即可
$sudo apt-get install subversion
~~~
___
svn的基本常用命令
- 检索文件[在git那边简称克隆项目]
~~~
 $svn co svn://git.sameple.com/project #这里是svn的协议加上项目的名称
~~~
- 提交修 改的 文件（commit）
      进入需要更新的目录，输入命令：
~~~
$svn commit -m path-to-commit #其中path-to-commit可以为空，成功后会提示更新后的版本号
~~~
- 更新文件（update）
~~~
$svn update，在要更新的目录运行这个命令就可以了。
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
