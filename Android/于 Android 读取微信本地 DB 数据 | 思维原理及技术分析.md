## WechatRecord | 微信记录解析

No matter where I am, I will reply you immediately when I see the email.My Email: echo "YUBzYW1lZ28uY29tCg==" | base64 -d



#### 前言

该移动端软件基于`Android`开发，是一个解析微信数据信息(包括微信个人资料、联系人、聊天记录等)并重装报文同步至服务端的一款应用。其实实属公司业务需要而开发的一个小玩意，`Android`嘛~笑O(∩_∩)O哈哈~。

应用的原理思维分析：首先拿到微信应用的本地`SQLite`数据库文件( 无网络的情况下可以显示之前的聊天记录，因而本地必有缓存数据的载体、G一下 额 是本地数据 )，分析到本地缓存以及找到文件的路径知识第一步，第二部需要**秘钥**进一步打开`db`文件，找到密码是很简单的事情( **再此感谢前人贡献** ) ，可以通过相关的信息计算得到，肯定会有人问：**万一微信将其改了那此方案此不是作废了吗？**，😁既然微信凭其技术实力改变了，那也没办法呀，但是我相信腾讯不会轻而易举的去做这一改动的，为何呢？**这样一改动的话，容易造成对之前版本不兼容**。既然`db`文件找到了以及秘钥也有了，最后一步就是理解与猜测数据表的结构与关系去做业务的开发。



#### 核心技术

- **`uin`理解与获取**

  > `uin`简单而言就是微信登录的识别号，设备必须有登录的历史才有。`uin`是如何获取的呢？

  ```java
  # uid在aunt_info_key_prefs.xml文件里面
  # 具体的路径为
  "/data/data/com.tencent.mm/shared_prefs/auth_info_key_prefs.xml"
  
  # uin的值为_auth_uin标签的值,如下是实例文件，可借助jsoup依赖库即可解析值
  ```

  

- **`imei码`**

  > 移动设备的唯一编码，双卡双待的会有两个。与数据库秘钥息息相关。

  ```
  public static String imei(Context context) {
      try {
      	//实例化TelephonyManager对象
      	TelephonyManager telephonyManager = (TelephonyManager) 	context.getSystemService(Context.TELEPHONY_SERVICE);
      	String imei = telephonyManager.getDeviceId();
      	if (imei == null) {
      		imei = "";
      	}
      	return imei;
      } catch (Exception e) {
      	e.printStackTrace();
      }
      return null;
  }
  ```



- **数据库路径**

  ```java
  # 路径为
  "/data/data/com.tencent.mm/MicroMsg/" + md5("mm" + uin) + "/EnMicroMsg.db";
  ```

  

- **数据库的密码**

  > 秘钥为`emei`+`uin`的`md5`截取前七位再转大写即可获取。

  ```java
  md5(imei + uin))).substring(0, 7).toLowerCase()
  ```



- **数据库读写操作**

  ```java
  import net.sqlcipher.Cursor;
  import net.sqlcipher.SQLException;
  import net.sqlcipher.database.SQLiteDatabase;
  import net.sqlcipher.database.SQLiteDatabaseHook;
  
  SQLiteDatabase.loadLibs(context);
  SQLiteDatabaseHook hook = new SQLiteDatabaseHook() {
  	@Override
      public void preKey(SQLiteDatabase database) {
  
      }
  
      @Override
      public void postKey(SQLiteDatabase database) {
          database.rawExecSQL("PRAGMA cipher_migrate;"); // 兼容2.0的数据库
      }
  };
  String file = "数据库备份后的文件路径;
  String password = "秘钥";
  SQLiteDatabase database = SQLiteDatabase.openOrCreateDatabase(file, password, null, hook);
  ... ...
  ```

