**前言**
    最近电脑总是在开机的后一段时间，系统的温度猛升，上升100°C真是So Easy啊，我也是无奈，也许之前玩的应用太多残留( 其一：Chrome很厉害 )，过几天找过时间清理清理。即时PC已经安装了系统监控，可以显示系统当前的温度等数据，但是呢，一做起事来，哪有空看到PC顶部的温度数据哇，还是桌面通知好，先来暂时解决解决先！
___
**方案**
实时读取系统的温度，当温度过高的时候，马上在通过桌面通知用户，这时候就kill了。
>使用`sensors`获取系统温度
使用`notify-send`发送通知

___
**实现**
如何实现呢，很简单，略懂shell直接看代码`temcheck.sh`
```shell
#!/bin/bash
# AlicFeng alic@samego.com 价值源于技术，技术源于分享
# 安装 func
function i(){
    sudo apt-get install apt-get install lm-sensors && sudo modprobe coretemp
}

# 运行 func
function todo(){
    str=`sensors |awk '{print $2}'| sed -n '3p'`
    tem=${str:1:2}
    if [ $tem -gt 50 ]
    then
    notify-send -i dialog-warning "系统温度提醒" "$(whoami) 你的电脑温度过高 \n Quickly To Kill Your Bad Process"
    fi 
}

# 帮助 func
function h(){
    echo echo "Usage: $0 (install|todo|help)"
}

# main to start
case $1 in
    i)
        i
        ;;
    todo)
        todo
        ;;
    *)
        h
        ;;
esac
exit 0

```
PS
第一：在第一次实现之前，先来安装依赖软件
```
➜  ~ bash temcheck.sh i
```
第二：查看其用法
```
➜  ~ bash temcheck.sh h
```
第三：程序的核心，那就是温度数据读取并实现桌面通知
```
➜  ~ bash temcheck.sh todo
```
___
**Run**
为了方便，温度高于50度就提示，This is demo！
![temcheck Demo](http://upload-images.jianshu.io/upload_images/1678789-24588526acc19121.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___
**auto run**
一句话，那就是结合crontab运行了！
**shell script in github [传送或wget](https://github.com/alicfeng/Linux_env/blob/master/shell/os/monitor/temcheck.sh)**
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**



