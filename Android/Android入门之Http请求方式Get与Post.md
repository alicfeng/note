前言：在Android开发的过程中，必须会接触到数据交互(访问数据,写入数据等你等),既然接触到数据的交互，那么自然而然就是使用通讯间的协议来进行请求，最常见的协议就是Http协议，Http协议包括两个具体的请求方式-Get以及Post。
___
* Http请求方式Get与Post的简介
先来了解Http协议:Http(HyperText Transfer Protocol超文本传输协议)是一个设计来使客户端和服务器顺利进行通讯的协议。
HTTP在客户端和服务器之间以request-response protocol（请求-回复协议）工作。
简单来说呢，Get与Post就是基于http协议的网络数据交互方式。
___
* Get与Post的主要区别
在Android开发的过程中，该如何选择Http的Get还是Post来进行通讯呢？那就详细探索他们之间的差异。
1.get通常是从服务器上获取数据，post通常是向服务器传送数据。
2.get是把参数数据队列加到表单的 ACTION属性所指的URL中，值和表单内各个字段一一对应，在URL中可以看到，实际上就是URL拼接方式。post是通过HTTPpost机制，将表单内各个字段与其内容放置在HTML HEADER内一起传送到ACTION属性所指的URL地址。
3.对于get方式，服务器端用 Request.QueryString获取变量的值，对于post方式，服务器端用Request.Form获取提交的数据。
4.get 传送的数据量较小，不能大于1KB[IE,Oher:4]。post传送的数据量较大，一般被默认为不受限制。但理论上，IIS4中最大量为80KB，IIS5中为100KB。
5.get安全性非常低，post安全性较高。
___
* Android如何使用Get与Post协议
不多说，上代码展示(演示用户登录访问服务器)
```
public class LoginServer {    
   /**     
   *get的方式请求     
   *@param username 用户名     
   *@param password 密码     
   *@return 返回null 登录异常     
   */ 
public static String loginByGet(String username,String password){
        //get的方式提交就是url拼接的方式
        String path = "http://172.16.168.111:1010/login.php?username="+username+"&password="+password;
        try {
            URL url = new URL(path);
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setConnectTimeout(5000);
            connection.setRequestMethod("GET");
            //获得结果码
            int responseCode = connection.getResponseCode();
            if(responseCode ==200){
                //请求成功 获得返回的流
                InputStream is = connection.getInputStream();
                return IOSUtil.inputStream2String(is);
            }else {
                //请求失败
                return null;
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (ProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }
   /** * post的方式请求 
   *@param username 用户名 
   *@param password 密码 
   *@return 返回null 登录异常 
   */
    public static String loginByPost(String username,String password){
        String path = "http://172.16.168.111:1010/login.php";
        try {
            URL url = new URL(path);
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setConnectTimeout(5000);
            connection.setRequestMethod("POST");

            //数据准备
            String data = "username="+username+"&password="+password;
            //至少要设置的两个请求头
            connection.setRequestProperty("Content-Type","application/x-www-form-urlencoded");
            connection.setRequestProperty("Content-Length", data.length()+"");

            //post的方式提交实际上是留的方式提交给服务器
            connection.setDoOutput(true);
            OutputStream outputStream = connection.getOutputStream();
            outputStream.write(data.getBytes());

            //获得结果码
            int responseCode = connection.getResponseCode();
            if(responseCode ==200){
                //请求成功
                InputStream is = connection.getInputStream();
                return IOSUtil.inputStream2String(is);
            }else {
                //请求失败
                return null;
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (ProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }
```
