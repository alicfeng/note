**前言**
在EOS中，我是习惯将Docker隐藏的，想显示的时候就将鼠标移动过去，此时的Dock将即时显示出来，不延迟1微秒的时间，当然也可以搞成延迟。现在本已换成mac，在Mac下使用Dock感觉会有延迟，G下～果然有延迟，强迫症必须干掉。Dock终将要闪现的，延迟？是不存在的！

___
**设置操作**
打开终端输入如下命令即可将延迟干掉！
~~~
defaults write com.apple.Dock autohide-delay -float 0 && killall Dock
~~~

倘若你初恋是Mac或者Window，生命中没有与Linux交往过的话，你是可以恢复延迟的初状的。
~~~
defaults delete com.apple.Dock autohide-delay && killall Dock
~~~

**[价值源于技术，贡献源于分享](https://link.jianshu.com/?t=https://github.com/alicfeng)**
