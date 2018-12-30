前言：在开发安卓移动端时，几乎每一个app都需要连接网络，因此，对设备的网络状态检测是很有必要的！比如：检测当前网络是否可用，当前可用的网络是属于WIFI还是MOBILE等等。
___
**实现步骤流程：**
1 .获取ConnectivityManager对象
```
// 获取手机所有连接管理对象（包括对wi-fi,net等连接的管理）
Context context = activity.getApplicationContext();
ConnectivityManager connectivityManager = (ConnectivityManager)context.getSystemService(Context.CONNECTIVITY_SERVICE);
```
2、获取NetworkInfo对象
```
// 获取NetworkInfo对象
NetworkInfo[] networkInfo = connectivityManager.getAllNetworkInfo();
```
3、判断当前网络状态是否为连接状态
```
if (networkInfo[i].getState() == NetworkInfo.State.CONNECTED){ 
   return true;
}
```
4、在AndroidManifest.xml中添加访问当前网络状态权限
```
<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE"></uses-permission>
```
___
**已经封装好了的网络工具类**
```
package com.samego.alic.utils;
import android.content.Context;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;import android.telephony.TelephonyManager;
/**
 * 网络工具类
 * Created by alic on 16-4-8. 
*/
public class NetWorkUtils {   
/**     
* 判断是否有网络连接     
*    
* @param context  
* @return   
*/
    public static boolean isNetworkConnected(Context context) {
        if (context != null) {
            // 获取手机所有连接管理对象(包括对wi-fi,net等连接的管理) 
           ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
           // 获取NetworkInfo对象
            NetworkInfo networkInfo = manager.getActiveNetworkInfo();
           //判断NetworkInfo对象是否为空
            if (networkInfo != null)
                return networkInfo.isAvailable(); 
       }
        return false; 
   }    
/**
* 判断WIFI网络是否可用
* 
* @param context 
* @return
/
    public static boolean isWifiConnected(Context context) {
        if (context != null) { 
          // 获取手机所有连接管理对象(包括对wi-fi,net等连接的管理)
           ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
            // 获取NetworkInfo对象
            NetworkInfo networkInfo = manager.getActiveNetworkInfo(); 
         //判断NetworkInfo对象是否为空 并且类型是否为WIFI
            if (networkInfo != null && networkInfo.getType() == ConnectivityManager.TYPE_WIFI) 
               return networkInfo.isAvailable();
        }        return false;
    }   
 /**
* 判断MOBILE网络是否可用
*
* @param context
* @return
*/
    public static boolean isMobileConnected(Context context) {
        if (context != null) {
            //获取手机所有连接管理对象(包括对wi-fi,net等连接的管理)
            ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
           //获取NetworkInfo对象
            NetworkInfo networkInfo = manager.getActiveNetworkInfo();
            //判断NetworkInfo对象是否为空 并且类型是否为MOBILE 
           if (networkInfo != null && networkInfo.getType() == ConnectivityManager.TYPE_MOBILE)
                return networkInfo.isAvailable();
        } 
      return false; 
   }    
/**
* 获取当前网络连接的类型信息
* 原生
*
* @param context
* @return
*/    public static int getConnectedType(Context context) {
        if (context != null) {
            //获取手机所有连接管理对象
            ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
            //获取NetworkInfo对象
            NetworkInfo networkInfo = manager.getActiveNetworkInfo();
            if (networkInfo != null && networkInfo.isAvailable()) {
                //返回NetworkInfo的类型
                return networkInfo.getType();
            }
        }
        return -1; 
   }
/**
* 获取当前的网络状态 ：没有网络-0：WIFI网络1：4G网络-4：3G网络-3：2G网络-2
* 自定义
*
* @param context
* @return
*/
    public static int getAPNType(Context context) {
        //结果返回值
        int netType = 0;
        //获取手机所有连接管理对象
        ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        //获取NetworkInfo对象
       NetworkInfo networkInfo = manager.getActiveNetworkInfo();
        //NetworkInfo对象为空 则代表没有网络
        if (networkInfo == null) { 
           return netType;
        }
        //否则 NetworkInfo对象不为空 则获取该networkInfo的类型
        int nType = networkInfo.getType();
        if (nType == ConnectivityManager.TYPE_WIFI) {
            //WIFI
            netType = 1;
        } else if (nType == ConnectivityManager.TYPE_MOBILE) {
            int nSubType = networkInfo.getSubtype();
           TelephonyManager telephonyManager = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
            //3G   联通的3G为UMTS或HSDPA 电信的3G为EVDO
            if (nSubType == TelephonyManager.NETWORK_TYPE_LTE 
                   && !telephonyManager.isNetworkRoaming()) {
                netType = 4;
            } else if (nSubType == TelephonyManager.NETWORK_TYPE_UMTS
                    || nSubType == TelephonyManager.NETWORK_TYPE_HSDPA
                    || nSubType == TelephonyManager.NETWORK_TYPE_EVDO_0
                    && !telephonyManager.isNetworkRoaming()) {
                netType = 3;
                //2G 移动和联通的2G为GPRS或EGDE，电信的2G为CDMA
            } else if (nSubType == TelephonyManager.NETWORK_TYPE_GPRS
                    || nSubType == TelephonyManager.NETWORK_TYPE_EDGE
                    || nSubType == TelephonyManager.NETWORK_TYPE_CDMA
                    && !telephonyManager.isNetworkRoaming()) {
                netType = 2;
           } else {
                netType = 2; 
           }
        }
        return netType;
    }
/**     
* 判断GPS是否打开     
*ACCESS_FINE_LOCATION权限     
* @param context     
* @return     
*/    
public static boolean isGPSEnabled(Context context) {       
 //获取手机所有连接LOCATION_SERVICE对象        
LocationManager locationManager = ((LocationManager) context.getSystemService(Context.LOCATION_SERVICE));
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);
    }
}
```
___
**网络信号详解**
___
**Added in API level 1**
```
public static final int NETWORK_TYPE_UNKNOWN
Network type is unknown
Constant Value: 0 (0x00000000)
(不知道网络类型)
 ```
```
public static final int NETWORK_TYPE_GPRS
Current network is GPRS
Constant Value: 1 (0x00000001)
(2.5G）移动和联通
  ```
```
public static final int NETWORK_TYPE_EDGE
Current network is EDGE
Constant Value: 2 (0x00000002)
(2.75G)2.5G到3G的过渡    移动和联通
  ```
```
public static final int NETWORK_TYPE_UMTS
Current network is UMTS
Constant Value: 3 (0x00000003)
(3G)联通
  ```
**Added in API level 4**
```
public static final int NETWORK_TYPE_CDMA
Current network is CDMA: Either IS95A or IS95B
Constant Value: 4 (0x00000004)
(2G 电信)
  ```
```
public static final int NETWORK_TYPE_EVDO_0
Current network is EVDO revision 0
Constant Value: 5 (0x00000005)
( 3G )电信
  ```
```
public static final int NETWORK_TYPE_EVDO_A
Current network is EVDO revision A
Constant Value: 6 (0x00000006)
(3.5G) 属于3G过渡
  ```
```
public static final int NETWORK_TYPE_1xRTT
Current network is 1xRTT
Constant Value: 7 (0x00000007)
( 2G )
  ```
**Added in API level 5**
```
public static final int NETWORK_TYPE_HSDPA
Current network is HSDPA
Constant Value: 8 (0x00000008)
(3.5G )
  ```
```
public static final int NETWORK_TYPE_HSUPA
Current network is HSUPA
Constant Value: 9 (0x00000009)
( 3.5G )
  ```
```
public static final int NETWORK_TYPE_HSPA
Current network is HSPA
Constant Value: 10 (0x0000000a)
( 3G )联通
  ```
**Added in API level 8**
```
public static final int NETWORK_TYPE_IDEN
Current network is iDen
Constant Value: 11 (0x0000000b)
(2G )
 ```
**Added in API level 9**
```
public static final int NETWORK_TYPE_EVDO_B
Current network is EVDO revision B
Constant Value: 12 (0x0000000c)
3G-3.5G
 ```
**Added in API level 11**
```
public static final int NETWORK_TYPE_LTE
Current network is LTE
Constant Value: 13 (0x0000000d)
(4G)
 ```
```
public static final int NETWORK_TYPE_EHRPD
Current network is eHRPD
Constant Value: 14 (0x0000000e)
3G(3G到4G的升级产物)
 ```
**Added in API level 13**
```
public static final int NETWORK_TYPE_HSPAP
Current network is HSPA+
Constant Value: 15 (0x0000000f)
( 3G )
```
___
**网络信号简记**
>4G  LTE
>3G    联通的3G为HSDPA或HSDPAP   电信的3G为EVDO    移动3G为UMTS
>2G 移动和联通的2G为GPRS或EGDE   电信的2G为CDMA

___
