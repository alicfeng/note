前言：从学习Android已经有十周时间了，之前都在学习PHP脚本语言，曾经还用纯php写了一个小型论坛，虽然不难，即使你用的东西自己同样封装了，但是最终总是感觉不太舒服，后来就用了国内的ThinkPHP框架作为框架学习，然而就慢慢体验到了使用框架的好处，比如优化的程序较好，更容易学习到框架里面不错的知识模块......
其实Android也是一样的，倘若你开发一个项目的话，一切都从零开始，嘿嘿，那你就可悲╮(╯▽╰)╭，对于开源的东西，学会选择轮子以及会用轮子对于开发项目是非常重要的，接下来介绍的轮子就是Android-Universal-Image-Loader图片加载框架。
___
**Android-Universal-Image-Loader简介**
Android-Universal-Image-Loader是当前非常流行的一款开源图片加载框架。
___
**Android-Universal-Image-Loader优点**

- 多线程下载图片，图片可以来源于网络，文件系统，项目文件夹assets中以及drawable中等
- 支持随意的配置ImageLoader，例如线程池，图片下载器，内存缓存策略，硬盘缓存策略，图片显示选项以及其他的一些配置
- 支持图片的内存缓存，文件系统缓存或者SD卡缓存
- 支持图片下载过程的监听
- 根据控件(ImageView)的大小对Bitmap进行裁剪，减少Bitmap占用过多的内存
- 较好的控制图片的加载过程，例如暂停图片加载，重新开始加载图片，一般使用在ListView,GridView中，滑动过程中暂停加载图片，停止滑动的时候去加载图片
- 提供在较慢的网络下对图片进行加载
___

**Android-Universal-Image-Loader使用**
为了避免配置使用重复的代码，自己编写了点小封装
Step-One：配置ImageLoaderConfiguration
~~~
package com.samego.alic.androidutils.common;
/**
 * Created by alic on 16-5-17.
 */
public class SameGoApplication extends Application {
    @Override
    public void onCreate() {
        super.onCreate();
        initImageLoaderConfiguration(getApplicationContext());
    }

    /**
     * 初始化ImageLoaderConfiguration配置
     *
     * @param context 上下文
     */
    public void initImageLoaderConfiguration(Context context) {
        //缓存文件目录
        File cacheDir = StorageUtils.getCacheDirectory(context);
        //构建配置
        ImageLoaderConfiguration config = new ImageLoaderConfiguration.Builder(context)
                //默认屏幕的大小
                .memoryCacheExtraOptions(480, 800)
                        // 内存缓存的设置选项 (最大图片宽度,最大图片高度) 默认当前屏幕分辨率
                .diskCacheExtraOptions(480, 800, null)
                        // 设置自定义加载和显示图片的线程池
                .taskExecutor(DefaultConfigurationFactory.createExecutor(3, Thread.NORM_PRIORITY, QueueProcessingType.LIFO))
                        // 设置自定义加载和显示内存缓存或者硬盘缓存图片的线程池
                .taskExecutorForCachedImages(DefaultConfigurationFactory.createExecutor(3, Thread.NORM_PRIORITY, QueueProcessingType.LIFO))
                        // 设置显示图片线程池大小，默认为3
                        // 注:如果设置了taskExecutor或者taskExecutorForCachedImages 此设置无效
                .threadPoolSize(3)
                        // 设置图片加载线程的优先级,默认为Thread.NORM_PRIORITY-1
                        // 注:如果设置了taskExecutor或者taskExecutorForCachedImages 此设置无效
                .threadPriority(Thread.NORM_PRIORITY - 2) // default
                        // 设置图片加载和显示队列处理的类型 默认为QueueProcessingType.FIFO
                        // 注:如果设置了taskExecutor或者taskExecutorForCachedImages 此设置无效
                .tasksProcessingOrder(QueueProcessingType.FIFO) // default
                        // 设置拒绝缓存在内存中一个图片多个大小 默认为允许,(同一个图片URL)根据不同大小的imageView保存不同大小图片
                .denyCacheImageMultipleSizesInMemory()
                        // 设置内存缓存 默认为一个当前应用可用内存的1/8大小的LruMemoryCache
                .memoryCache(new LruMemoryCache(2 * 1024 * 1024))
                        // 设置内存缓存的最大大小 默认为一个当前应用可用内存的1/8
                .memoryCacheSize(2 * 1024 * 1024)
                        // 设置内存缓存最大大小占当前应用可用内存的百分比 默认为一个当前应用可用内存的1/8
                .memoryCacheSizePercentage(13) // default
                        // 设置硬盘缓存
                .diskCache(new UnlimitedDiskCache(cacheDir)) //缓存路径
                        // 设置硬盘缓存的最大大小
                .diskCacheSize(50 * 1024 * 1024)
                        // 设置硬盘缓存的文件的最多个数
                .diskCacheFileCount(100)
                        // 设置硬盘缓存文件名生成规范
                .diskCacheFileNameGenerator(new HashCodeFileNameGenerator()) // default
                        // 设置图片下载器
                .imageDownloader(new BaseImageDownloader(context)) // default
                        // 设置图片解码器
                .imageDecoder(DefaultConfigurationFactory.createImageDecoder(false))
                        // 设置默认的图片显示选项
                .defaultDisplayImageOptions(DisplayImageOptions.createSimple())
                        // 打印DebugLogs
                .writeDebugLogs()
                        //万事俱备 执行构造
                .build();
        //初始化配置文件
        ImageLoader.getInstance().init(config);
    }
}
~~~
Step-Two：配置DisplayImageOptions
~~~
package com.samego.alic.androidutils.common;
/**
 * 应用辅助配置文件
 * Created by alic on 16-5-17.
 */
public class AppConfig {
    public static DisplayImageOptions imageOptions() {
        /**
         * DisplayImageOptions所有配置简介
         */
        DisplayImageOptions options = new DisplayImageOptions.Builder()
                // 设置图片加载时的默认图片
                .showImageOnLoading(R.drawable.login_face)
                        // 设置图片加载失败的默认图片
                .showImageOnFail(R.drawable.login_face)
                        // 设置图片URI为空时默认图片
                .showImageForEmptyUri(R.drawable.login_face)
                        // 设置是否将View在加载前复位
                .resetViewBeforeLoading(false)
                        // 设置延迟部分时间才开始加载
                        // 默认为0
                .delayBeforeLoading(100)
                        // 设置添加到内存缓存
                        // 默认为false
                .cacheInMemory(true)
                        // 设置规模类型的解码图像
                        // 默认为ImageScaleType.IN_SAMPLE_POWER_OF_2
                .imageScaleType(ImageScaleType.IN_SAMPLE_POWER_OF_2)
                        // 设置位图图像解码配置
                        // 默认为Bitmap.Config.ARGB_8888
                .bitmapConfig(Bitmap.Config.ARGB_8888)
                        // 设置选项的图像解码
                .decodingOptions(new BitmapFactory.Options())
                        // 设置自定义显示器
                        // 默认为DefaultConfigurationFactory.createBitmapDisplayer()
                .displayer(new FadeInBitmapDisplayer(300))
                        // 设置自定义的handler
                        // 默认为new Handler()
                .handler(new Handler())
                        // 建立
                .build();
        return options;
    }
}
~~~
Step-Three：然后可以使用啦
~~~
package com.samego.alic.androidutils.view;

public class MainActivity extends AppCompatActivity {
    private ImageView imageView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        initVIew();
    }

    public void initVIew() {
        imageView = (ImageView) findViewById(R.id.imageVIew);
        //看这里使用，很简单的一行代码
        ImageLoader.getInstance().displayImage("http://home.sise.cn/img/LOGO.png",imageView, AppConfig.imageOptions());
    }
}
~~~
配置后具体使用的其它方法
Acceptable URIs examples
~~~
"http://site.com/image.png" // from Web
"file:///mnt/sdcard/image.png" // from SD card
"file:///mnt/sdcard/video.mp4" // from SD card (video thumbnail)
"content://media/external/images/media/13" // from content provider
"content://media/external/video/media/13" // from content provider (video thumbnail)
"assets://image.png" // from assets
"drawable://" + R.drawable.img // from drawables (non-9patch images)

Simple

ImageLoader imageLoader = ImageLoader.getInstance();

imageLoader.displayImage(imageUri, imageView);
//支持回调方法
imageLoader.loadImage(imageUri, new SimpleImageLoadingListener() {
    @Override
    public void onLoadingComplete(String imageUri, View view, Bitmap loadedImage) {
        //你要干嘛( ⊙o⊙ )哇
    }
});

// 异步加载得到Bitmap
Bitmap bmp = imageLoader.loadImageSync(imageUri);


// 加载图片更是可以支持监听
imageLoader.displayImage(imageUri, imageView, options, new ImageLoadingListener() {
    @Override
    public void onLoadingStarted(String imageUri, View view) {
        //你要干嘛( ⊙o⊙ )哇
    }
    @Override
    public void onLoadingFailed(String imageUri, View view, FailReason failReason) {
         //你要干嘛( ⊙o⊙ )哇
    }
    @Override
    public void onLoadingComplete(String imageUri, View view, Bitmap loadedImage) {
         //你要干嘛( ⊙o⊙ )哇
    }
    @Override
    public void onLoadingCancelled(String imageUri, View view) {
        //你要干嘛( ⊙o⊙ )哇
    }
}, new ImageLoadingProgressListener() {
    @Override
    public void onProgressUpdate(String imageUri, View view, int current, int total) {
         //你要干嘛( ⊙o⊙ )哇 更新UI进度条罗
    }
});
// Load image, decode it to Bitmap and return Bitmap to callback看看简单的官方英文
ImageSize targetSize = new ImageSize(80, 50); // result Bitmap will be fit to this size
imageLoader.loadImage(imageUri, targetSize, options, new SimpleImageLoadingListener() {
    @Override
    public void onLoadingComplete(String imageUri, View view, Bitmap loadedImage) {
        // Do whatever you want with Bitmap
    }
});
// Load image, decode it to Bitmap and return Bitmap synchronously看看简单的官方英文
ImageSize targetSize = new ImageSize(80, 50); // result Bitmap will be fit to this size
Bitmap bmp = imageLoader.loadImageSync(imageUri, targetSize, options);
~~~
___
**[Github:Android-Universal-Image-Loader](https://github.com/nostra13/Android-Universal-Image-Loader)**
对于开发者来说使用好的轮子的确是很重要的，要是上面出现错误的地方望指出并多多交流，要是有更好的简单封装方式感谢留言分享！


**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
