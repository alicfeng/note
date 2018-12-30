**一：weblogic 页面访问速度比tomcat慢的原因和解决办法**
 
项目部署在weblogic之后，发现比在tomcat下慢很多，原因是web应用的WEB-INF下的weblogic.xml里的参数设置不合理（使用默认值有时并非最佳值）造成的，具体说明如下：
 
**1：pageCheckSeconds**
```
<jsp-descriptor>
   <param-name>pageCheckSeconds</param-name>   <param-value>-1</param-value>
</jsp-descriptor>
 ```
pageCheckSecond的默认值是1，表示每隔1秒对JSP页面进行检查，检查JSP页面是否被修改、是否需要重新编译。
系统上线后，需要对该默认值修改为-1，表示永不检查。修改为-1的一个缺点是：对于页面的修改需要重新部署整个WEB应用。
 
**2：servlet-reload-check-secs**
 
该参数的默认值也是1，每隔1秒检查servlet是否被修改并需要重新编译。这里建议修改为-1，表示永不检查，具体设置如下：
```
<container-descriptor>   
 <servlet-reload-check-secs>-1</servlet-reload-check-secs> 
</container-descriptor>
 ```
 
**二：应用程序的jar包和weblogic类冲突的问题**
 
项目部署Tomcat下没有问题，但是部署在weblogic下就出了问题，最可能造成这样的原因是应用程序的jar包和weblogic下的jar包冲突。可以在weblogic.xml里设置，具体如下：
```
<container-descriptor>
   <prefer-web-inf-classes>true</prefer-web-inf-classes> 
</container-descriptor>
``` 
**从节点名称上也能比较清楚知道该设置的含义，优先使用Web应用里加载的类。**
** 
**三：查看weblogic编译jsp文件产生的.java文件**
```
   <jsp-param>
 <param-name>keepgenerated</param-name> 
 <param-value>true</param-value> 
</jsp-param>
```
