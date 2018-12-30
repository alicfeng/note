**前言**
Chrome浏览器扩展开发算是相当简单的，基本只要掌握HTML+CSS+Javascript，即可快速开发一个属于你的Chrome插件！
___

**Chrome扩展基本目录结构**
~~~
manifest.json  这是一个配置文件，里面记录了扩展的使用范围、作者、版本、其余需要加载的文件等内容;
icon.png       这个一看便知，就是扩展的图标～～～
popup.html     点击扩展图标，弹出的面板页面（如果在manifest.json中配置了default_popup为该文件的话）
popup.js       popup面板加载的js脚本文件
popup.css      popup面板加载的css样式文件  
~~~
- 具体分析manifest.json插件的配置文件

~~~
{  
    "name": "Alic",  //插件的名称
    "version": "0.1.0", //扩展的版本
    "manifest_version":2, //这个是必须的，并且值为2
    "description": "Chrome扩展demo",  //扩展的基本描述
    "browser_action": {  
        "default_icon": "icon.png" , //插件图标icon位置
        "default_title": "默认标题", //鼠标hover是的标题
        "default_popup": "popup.html" //单击图标popup出来的面板
    },
    "permissions":[
        "http://www.samego.com"
    ]
} 
~~~
其它属性的详细说明
`permissions`
permissions 属性是一个数组，它定义了扩展需要向 Chrome 申请的权限，比如通过 XMLHttpRequest 跨域请求数据、访问浏览器选项卡（tabs）、获取当前活动选项卡（activeTab）、浏览器通知（notifications）、存储（storage）等，可以根据需要添加。
~~~
{
    "permissions": [
        "http://api.example.com/api/"
        "tabs",
        "activeTab",
        "notifications",
        "storage"
    ]
}
~~~

`background`
background 可以使扩展常驻后台，比较常用的是指定子属性 scripts，表示在扩展启动时自动创建一个包含所有指定脚本的页面。
~~~
{
    "background": {
        "scripts": ["./public/js/background.js"]
    }
}
~~~

`chrome_url_overrides`
chrome_url_overrides 属性可以自定义的页面替换 Chrome 相应默认的页面，比如新标签页（newtab）、书签页面（bookmarks）和历史记录（history）。
~~~
{
    "chrome_url_overrides": {
        "newtab": "tab.html"
    }
}
~~~
___

**Chrome扩展调试**
menu->设置->扩展程序
注意：将开发者模式选中～～～
The first = 点击加载已解压的扩展程序，并选择扩展程序的目录
完成后会在项目的根目录生成xx.crx以及xx.pem两个文件
The second = 查看浏览器的工具栏

我的插件dir-tree

![Alic_dir](http://upload-images.jianshu.io/upload_images/1678789-35e8fac86f90affc.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
![ALic_Chrome](http://upload-images.jianshu.io/upload_images/1678789-374fe78846f6c788.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
![Alic_Chrome](http://upload-images.jianshu.io/upload_images/1678789-0aa3a2a46fa2a692.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
简单的扩展插件就完成了 ～～～
___
**background交互**
简单来说呢，上面完成的其实就是一个扩展程序的微框架。
background顾名思义呢就是扩展程序的后台脚本，该脚本在程序运行之后一直处于后台运行状态。记录常用的API。

在background里绑定browserAction的点击事件定义事件响应处理
~~~
chrome.browserAction.onClicked.addListener(function(){  
     //to-do
});
~~~
调用chrome.tabs.create()来创建新的tab，url既可以是path也可以是网址
~~~
chrome.tabs.create({url: "./home/index.html"});
~~~

content script调用background方法
在background脚本定义方法
~~~
// 创建新标签页的自定义方法
function testDynamic(){
    chrome.tabs.create({url: "./home/index.html"});
}
~~~
在content script使用content script里定义的方法
~~~
var bg = chrome.extension.getBackgroundPage();   
bg.testDynamic();
~~~

content script与background交互
content script监听消息：
~~~
chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {});  
~~~
background发送消息：
~~~
chrome.tabs.sendRequest(tab.id, data, function(data) {});  
~~~
相反～～～

background监听消息：
~~~
chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {});  
~~~
content script侧发送消息：
~~~
chrome.extension.sendRequest(data, function(data) {}); 
~~~
开发一个简单Chrome扩展程序基本是没有什么大问题的！我的体会呢，要是主要用于离线的呢，还是开发应用好点，扩展程序也不是不可以，否则数据存储方面就使用js处理即可！
 ___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**














