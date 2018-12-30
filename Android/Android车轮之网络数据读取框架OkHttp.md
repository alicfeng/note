**OkHttp框架的介绍**
现在Android网络数据处理方面的第三方库文件还是不少的，比如：Volley，Retrofit，HttpClient，OKHttp等等，HttpClient库已经在Android6.+被废弃啦，而目前OkHttp库的技术已经比较成熟，可以这么说：为了让您的应用运行更快、更高效、更节省流量，那么OkHttp库就是为此而生。
___
**项目添加OkHttp框架**
最新的版本为：okhttp-3.2.0.jar 、okio-1.7.0.jar   |  [OkHttp框架Github](https://github.com/square/okhttp/pull/2082)
注意:使用OkHttp框架必须导入这两个库,OkHttp库要依赖okio库
___
更新说明
2016..5.23 增加OkHttp原生的方法
以Request作为参数请求
使用方法 
~~~
//原生的OkHttp方法 参数
Request request = new Request.Builder().build();
//原生的OkHttp方法 同步请求
OkHttpManager.execute(request);
//原生的OkHttp方法 异步请求 没回调
OkHttpManager.enqueue(request);
//原生的OkHttp方法 异步请求 有回调
OkHttpManager.enqueue(request, new Callback() {
    @Override
    public void onFailure(Call call, IOException e) {
        
    }

    @Override
    public void onResponse(Call call, Response response) throws IOException {

    }
});
~~~
___
**使用方法**
在此就不必啰嗦啦 - [官方API](https://github.com/square/okhttp/wiki/Recipes)
为了更方便学习与使用此框架，我就花费了点时间封装成了一个工具类

~~~
//GET 同步 返回Response
Response response = OkHttpManager.executeSync("http://www.baidu.com");

//GET 同步处理 get String
String string = OkHttpManager.executeSyncString("http://home.sise.cn");

//GET 异步 回调
OkHttpManager.enqueueAsync("http://home.sise.cn", new Callback() {
    @Override
    public void onFailure(Call call, IOException e) {

    }

    @Override
    public void onResponse(Call call, Response response) throws IOException {

    }
});

//异步处理 结果我才不鸟它呢
OkHttpManager.enqueueAsync("http://home.sise.cn");

//post异步处理 结果是我的装备
FormBody body = new FormBody.Builder()
        .add("username", "alic")
        .add("password", "alic")
        .build();
OkHttpManager.postEnqueueAsync("http://172.16.168.35:1010/login.php", body, new Callback() {
    @Override
    public void onFailure(Call call, IOException e) {

    }

    @Override
    public void onResponse(Call call, Response response) throws IOException {
        Log.e("Test", response.body().string());
    }
});

//POST 表单 动态数据 动态文件
//表单数据
HashMap<String, String> mapData = new HashMap<>();
mapData.put("username", "alic");
mapData.put("password", "alic");
//表单文件
File file1 = new File("/storage/sdcard1/1.png");
File file2 = new File("/storage/sdcard1/scs.jpg");
HashMap<String, File> mapFile = new HashMap<>();
mapFile.put("screen1",file1);
mapFile.put("screen2",file2);
//重点在这里
OkHttpManager.postFormAsync("http://172.16.168.35:1010/upload.php", mapData, mapFile, new Callback() {
    @Override
    public void onFailure(Call call, IOException e) {

    }

    @Override
    public void onResponse(Call call, Response response) throws IOException {
        System.out.println("form-" + response.body().string());
    }
});
~~~
是不是使用起来觉得很方便咧 简单封装如下
[具体封装github同步更新封装](https://github.com/alicfeng/Android-Utils)
~~~
package com.samego.alic.androidutils.utils;


import android.os.Environment;

import java.io.File;
import java.io.IOException;
import java.util.Map;
import java.util.concurrent.TimeUnit;

import okhttp3.Cache;
import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

/**
 * oKHttp的工具类
 * Created by alic on 16-5-20.
 */
public class OkHttpManager {
    /**
     * 静态实例
     */
    private static OkHttpManager okHttpManager;

    /**
     * OkHttpClient实例
     */
    private OkHttpClient client;

    /**
     * 单例模式
     * 对于但是模式网上有很对写法 实际得看需求
     *
     * @return OkHttpManager
     */
    private static OkHttpManager getInstance() {
        if (okHttpManager == null)
            okHttpManager = new OkHttpManager();
        return okHttpManager;
    }

    public static final MediaType MEDIA_TYPE_MARKDOWN = MediaType.parse("text/x-markdown; charset=utf-8");
    //post请求header-image
    private static final MediaType MEDIA_TYPE_PNG = MediaType.parse("image/*");

    /**
     * 构造方法
     */
    public OkHttpManager() {
        //实例化OkHttpClient
        client = new OkHttpClient();
        //配置okHttpClient的参数
        client.newBuilder().connectTimeout(10, TimeUnit.SECONDS);
        client.newBuilder().readTimeout(10, TimeUnit.SECONDS);
        client.newBuilder().writeTimeout(10, TimeUnit.SECONDS);
        //设置缓存信息的处理：创建缓存对象，构造方法用于控制缓存位置及最大缓存大小【单位是Byte】
        Cache cache = new Cache(new File(Environment.getExternalStorageDirectory().getPath()), 10 * 1024 * 1024);
        client.newBuilder().cache(cache);
    }


    //GET同步请求 返回Response

    /**
     * get请求 不开启异步线程 公开方法
     *
     * @param url 请求参数url
     * @return response 返回响应
     */
    public static Response executeSync(String url) {
        return OkHttpManager.getInstance().doExecuteSync(url);
    }

    /**
     * get请求 不开启异步线程 内部方法
     *
     * @param url 请求参数url
     * @return response 返回响应
     */
    private Response doExecuteSync(String url) {
        Request request = new Request.Builder().url(url).build();
        try {
            Response response = client.newCall(request).execute();
            if (response.isSuccessful())
                return response;
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }


    //GET同步请求并获取数据

    /**
     * get请求 同步线程 公开方法
     *
     * @param url url
     * @return String
     */
    public static String executeSyncString(String url) {
        return OkHttpManager.getInstance().doExecuteSyncString(url);
    }

    /**
     * get请求 同步线程 内部方法
     *
     * @param url url
     * @return String
     */
    private String doExecuteSyncString(String url) {
        try {
            Response response = doExecuteSync(url);
            if (response != null)
                return response.body().string();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }


    //GET 异步请求 内部方法

    /**
     * get 异步请求 公开方法
     * 对结果处理
     *
     * @param url url
     */
    public static void enqueueAsync(String url, Callback callback) {
        OkHttpManager.getInstance().doEnqueueAsync(url, callback);
    }

    /**
     * 自定义对结果处理 内部方法
     *
     * @param callback 回调方法
     */
    private void doEnqueueAsync(String url, Callback callback) {
        client.newCall(new Request.Builder().url(url).build()).enqueue(callback);
    }

    /**
     * get 异步请求 公开方法
     * 不对结果处理
     *
     * @param url url
     */
    public static void enqueueAsync(String url) {
        OkHttpManager.getInstance().doEnqueueAsync(url);
    }

    /**
     * 开启异步线程访问 内部方法
     * 不对结果处理
     */
    private void doEnqueueAsync(String url) {
        client.newCall(new Request.Builder().url(url).build()).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                //todo 这里虽然存在 但是不可以做羞羞事嗒
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                //todo 这里虽然存在 但是不可以做羞羞事嗒

            }
        });
    }

    //POST 异步访问 处理结果

    /**
     * post 异步访问 公开方法
     *
     * @param url      url
     * @param body     提交参数
     * @param callback 回调函数
     */
    public static void postEnqueueAsync(String url, RequestBody body, Callback callback) {
        OkHttpManager.getInstance().doPostEnqueueAsync(url, body, callback);
    }

    /**
     * post 异步访问 内部方法
     *
     * @param url      url
     * @param body     提交参数
     * @param callback 回调函数
     */
    private void doPostEnqueueAsync(String url, RequestBody body, Callback callback) {
        Request request = new Request.Builder()
                .url(url)
                .post(body)
                .build();
        //计划好了 那就干吧
        client.newCall(request).enqueue(callback);
    }


    //POST 异步访问 不处理结果

    /**
     * POST 异步访问 不处理结果 公开方法
     *
     * @param url  url
     * @param body body
     */
    public static void postEnqueueAsync(String url, RequestBody body) {
        OkHttpManager.getInstance().doPostEnqueueAsync(url, body);
    }

    /**
     * POST 异步访问 不处理结果 内部方法
     *
     * @param url  url
     * @param body body
     */
    private void doPostEnqueueAsync(String url, RequestBody body) {
        Request request = new Request.Builder()
                .url(url)
                .post(body)
                .build();
        //计划好了 那就干吧
        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                //todo 这里虽然存在 但是不可以做羞羞事嗒
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                //todo 这里虽然存在 但是不可以做羞羞事嗒

            }
        });
    }

    //POST  仅上传一个文件 对结果处理

    /**
     * 上传一个文件 公开方法
     * @param url url
     * @param file file
     * @param callback callback
     */
    public static void uploadFile(String url,File file,Callback callback){
        OkHttpManager.getInstance().doUploadFile(url,file,callback);
    }

    /**
     * 上传一个文件 内部方法
     * @param url url
     * @param file file
     * @param callback callback
     */
    private void doUploadFile(String url,File file,Callback callback){
        Request request = new Request.Builder()
                .url(url)
                .post(RequestBody.create(MEDIA_TYPE_MARKDOWN, file))
                .build();

        client.newCall(request).enqueue(callback);
    }

    //表单提交(带文件) 动态参数 动态文件
    /**
     * post 文件上传 公开方法
     *
     * @param url    url
     * @param params params
     * @param files  file
     */
    public static void postFormAsync(String url, Map<String, String> params, Map<String, File> files, Callback callback) {
        OkHttpManager.getInstance().doPostFormAsync(url, params, files, callback);
    }

    /**
     * 文件上传 内部方法
     *
     * @param url    url
     * @param params params
     * @param files  files
     */
    private void doPostFormAsync(String url, Map<String, String> params, Map<String, File> files, Callback callback) {

        MultipartBody.Builder builder = new MultipartBody.Builder();
        builder.setType(MultipartBody.FORM);

        //处理提交的参数
        if (params != null) {
            //map 遍历
            for (String key : params.keySet()) {
                //过滤 判断key是否为空
                if (!key.equals("")) {
                    builder.addFormDataPart(key, params.get(key));
                }
            }
        }
        //处理提交的文件
        if (files != null) {
            //次句暂且解决params为null
            builder.addFormDataPart("hidden", "debug");
            for (String key : files.keySet()) {

                //过滤 判断key是否为空
                if (!key.equals("")) {
                    builder.addFormDataPart(key, key, RequestBody.create(MEDIA_TYPE_PNG, files.get(key)));
                    System.out.println("form- add");
                }
            }
        }
        MultipartBody body = builder.build();

        Request request = new Request.Builder()
                .url(url)
                .post(body)
                .build();
        client.newCall(request).enqueue(callback);
    }
}

~~~
若对上文所说的有误或更好的code非常欢迎留言或简信！THX
[Github-Adress  Android-Utils](https://github.com/alicfeng/Android-Utils)
**持续更新~~~**

**价值源于技术，贡献源于分享**

更多轮子详情请看：
Android车轮之网络数据读取框架OkHttp
[Android车轮之图片加载框架Android-Universal-Image-Loader](http://www.jianshu.com/p/e1340dbf77d6)
