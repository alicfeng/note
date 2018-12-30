前言：今天学习httpclient时，导入了httpClient以及httpCore两个jar文件，在编译的时候没有问题，然而在运行打包的时候出现了问题：Duplicate files copied in APK META-INF/NOTICE。
___
* 问题：

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-a410339157d419c1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
* 问题的原因：
因为多个jar都有META-INF/NOTICE这个文件.这是打jar包的时候生成的.
而现在你项目依赖两个都有的这种.而你编译出来的是同一個apk.这些文件都会合并在一齐.而这两个文件重名了.就影响到了打包.而写这两句是代表.把这些文件都del掉来打包.所以就能正常打包了.
___
* 解决办法：

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-323149404fbb05e3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
如图所示，在文件上添加
packagingOptions{    
exclude 'META-INF/LICENSE'    
exclude 'META-INF/NOTICE'    
exclude 'META-INF/DEPENDENCIES'
}
___
然而问题就解决啦。
