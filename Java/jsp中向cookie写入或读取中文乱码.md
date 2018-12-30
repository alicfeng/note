前言：JavaWeb中Cookie不能直接存中文，中文必须编码成asccii串才行
**Step-one：存储cookie**
```
String   str   =   java.net.URLEncoder.encode("中文","UTF-8");  
```
**Step-two：读取cookie**
```
String   str   =   java.net.URLDecoder.decode(cookies[i].getValue(),"UTF-8");  
```
