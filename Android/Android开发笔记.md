- tableRow 平分固定宽度
每一列的宽度设置为android:layout_width="0.0dip"，在设置每一列的android:layout_weight=“1”因为ayout_weight是将剩余空间按权重分配，而不是将全部空间按权重分配
注意：android:layout_width="match_parent或wrap_content"都不可以
___
- 简单来说，**Bundle**就是用来传参数的【键值对key-value】在使用Bundle传递数据时，要注意，Bundle的大小是有限制的 < 0.5MB，如果大于这个值 是会报TransactionTooLargeException异常的。
___
- 对于需要软件本身需要用到的程序系统变量，然而我们可以使用**SharedPreferences**，它是Android中最容易理解的数据存储技术，实际上SharedPreferences处理的就是一个键值对。 SharedPreferences常用来存储一些轻量级的数据。
___
- 在xml的布局文件中，往往使用dp作为控件的宽度和高度尺寸，但是在Java代码中，调用getWidth()方法获得的尺寸单位却是像素px,这两个单位有明显的区别：dp和屏幕的密度有关，而px与屏幕密度无关，所以使用时经常会涉及到两者之间的互相转化，代码示例如下：
```
public int dp2Px(Context context, float dp) {
final float scale = context.getResources().getDisplayMetrics().density;
return (int) (dp * scale + 0.5f);
}
```
```
public int px2Dp(Context context, float px) {
final float scale = context.getResources().getDisplayMetrics().density;
return (int) (px / scale + 0.5f);
}
```
___
* Android在开发的过程中遇到流的转化的不可避免的，往往就需要进行互相转化，整理代码如下:
```
public static String inputStream2String(InputStream is) throws IOException {   
 ByteArrayOutputStream baoStream = new ByteArrayOutputStream();  
 int i = -1;   
 while ((i = is.read()) != -1) { 
      baoStream.write(i);  
  }  
  return baoStream.toString();}
```
```
public static InputStream String2inputSteam(String string) throws UnsupportedEncodingException {   
      return new ByteArrayInputStream(string.getBytes());
}
```
___
* Android获取网络状态，现在开发的任一款app几乎都需要连接网络，对设备的网络状态检测是很有必要的！
详细讲解在[Android获取网络状态][1]  源码下载[百度云盘][2]
[1]:http://www.jianshu.com/p/10ed9ae02775
[2]:http://pan.baidu.com/s/1gflnbCv
___
