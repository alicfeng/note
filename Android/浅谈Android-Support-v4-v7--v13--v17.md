前言：今天在开发应用的时候用到android-support-v7-appcompat以及support-v4这两个依赖库的时候遇到一些问题，code在编译的时候没有问题，在run的时候却报错函数找不到【ViewCompat.setFitsSystemWindows符号找不到】。
___
* **Android Support v4 v7  v13  v17的简介**
简单上来说：他们本质上就是java library。
___
* **为什么需要Android Support依赖库**
在 Android 开发中，在低版本Android平台上开发一个应用程序时，为了使用高版本API的新特性以及功能，那么就需要添加额外的包来使用这些新特性，就需要使用Support库。
___
* **为什么需要Android Support的分类**
###### Android Support v4：
 这个包是为了照顾**Android 1.6及以上版本**而设计的，在开发中，默认都会使用到这个包
###### Android Support v7：
 这个包是为了照顾**Android 2.1及以上版本**而设计的，但是不能兼容低版本 Android 系统，如果开发中不考虑 1.6 ，可以采用这个包。另外要注意：**v7 包是依赖 v4 包的，即引入 v7 包的话要同时引入 v4 包，必须是同版本的【在sdk-v7的libs目录存在这两个包】**
###### Android Support v13： 
这个包是为了照顾**Android 3.2及以上版本**而设计的，一般开发中不会用到，平板开发可能会用到
___
* **如何使用Android Support**
当今很多的开发工具在创建工程的时候就默认添加了v4这个依赖库，比如AS Eclipse等。但是，有时候我们需要查看v4的资源文件类是不可以的。不过，在工程添加依赖库文件是有很多的方法的。
比如file dependence/ library dependence/module dependence等，想看到源码的可以利用 file dependence的方式来添加依赖文件，目标依赖会在libs下
这些库可以从sdk下的 sdk/extras/android/support 中获取
具体：Click Module -> Right Cilck -> Open Module Settings ->Dependence
添加后将会在**build.gradle**查看
___
* **使用Android Support注意事项**
项目需用引入两个库文件的时候，比如需要用到Support-v7，由于v7是依赖v4的，那么就必须引入两个library，
与此同时，引入的两个Support必须是同样的版本的，最可靠的办法就是在v7的libs目录下会存在v4以及v7这两个jar文件，在项目依赖添加这两个依赖即可。
虽然引进了v4和v7，但是版本不一样的话那就很可能出现v4与v7兼容性发生冲突，直接看图
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-7d228cfd74ca3b4a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
解决的办法就是就是在v7的libs目录下会存在v4以及v7这两个jar文件，在项目依赖添加这两个依赖即可。
___

