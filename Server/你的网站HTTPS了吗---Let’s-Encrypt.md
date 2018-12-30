**前言**
      下午，图书馆闭馆了了、得找一个安全的地方上网\(^o^)/~，一直听说着Let’s Encrypt。前几天玩了一下，但是本地运行Let’s Encrypt不能生成证书，Maybe School DNS question :-D，那就在腾讯云服务器玩玩。
___

**Let’s Encrypt**
        [Let's Encrypt](https://letsencrypt.org/)是由EFF、Mozilla、Cisco、Akamai、IdenTrust与密西根大学研究人员共同创立的免费的凭证中心，目的在于推动全球所有的网站都使用HTTPS加密传输，创建一个更安全、更具隐私性的Web。目前Let’s Encrypt由非营利的网际网路安全研究组织(ISRG)负责营运。

![Let’s Encrypt](http://upload-images.jianshu.io/upload_images/1678789-a6731e3564bd37ed.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

**如何配置HTTPS**
 - 生成证书
我们先在github克隆letsencrypt项目，然后生成证书。

```shell
git clone https://github.com/letsencrypt/letsencrypt
cd ./letsencrypt

# 生成证书
./letsencrypt-auto certonly -d domain.com -d www.domain.com
```
>注意：请将domain换成对应要生成证书的域名！！！

执行脚本之后有三种生成证书的方式可选，一般选择standalone即可。
```
1: Apache Web Server plugin - Beta (apache)
2: Place files in webroot directory (webroot)
3: Spin up a temporary webserver (standalone)
```
成功的话将会返回如下的信息
```
IMPORTANT NOTES:
 - Congratulations! Your certificate and chain have been saved at
   /etc/letsencrypt/live/samego.com/fullchain.pem. Your cert will
   expire on 2017-07-13. To obtain a new or tweaked version of this
   certificate in the future, simply run letsencrypt-auto again. To
   non-interactively renew *all* of your certificates, run
   "letsencrypt-auto renew"
```
并且我们可以从返回的信息知道生成证书的储存目录位于` /etc/letsencrypt/live/domain.com/`，一共生成四个证书文件，一般情况下 fullchain.pem 和 privkey.pem 就够用了。

| 文件名  | 文件作用   | 
| ---- | ---- | ---- |
|cert.pem	|  服务端证书|
|chain.pem|	浏览器需要的所有证书但不包括服务端证书，比如根证书和中间证书|
|fullchain.pem|	包括了cert.pem和chain.pem的内容|
|privkey.pem|	证书的私钥|

证书的有效期为三个月，过期后我们需要重新生成证书，letsencrypt内已经有指令重新生成。
```
/opt/certbot/letsencrypt-auto renew
```
为了方便呢，我们可以crontab定时重新生成证书，如何定时呢就不说了。

___

- 配置nginx
要修改的nginx的配置文件位于`/etc/nginx/sites-enabled/default`。

```
server {
	listen 443;
    #domain修改成你的域名即可
	server_name domain.com www.domain.com; 

	ssl on;
    #fullchain证书路径
	ssl_certificate /etc/letsencrypt/live/domain.com/fullchain.pem;
    #privkey证书路径
	ssl_certificate_key /etc/letsencrypt/live/domain.com/privkey.pem;
	ssl_session_timeout 5m;
	ssl_protocols SSLv3 TLSv1 TLSv1.1 TLSv1.2;
	ssl_ciphers "HIGH:!aNULL:!MD5 or HIGH:!aNULL:!MD5:!3DES";
	ssl_prefer_server_ciphers on;

    # 下面是我个人反代理的，不用管!!!
    	location / {
        	proxy_redirect off;
        	proxy_set_header Host $host;
        	proxy_set_header X-Real-IP $remote_addr;
        	proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
       		proxy_pass https://alicfeng.github.io;
    }
}
```
最后，我们重启nginx服务器即可！**要是nginx起不来的话，那就看看日志!!!**
```
# 重启nginx
sudo systemctl restart nginx.service

# 万一起不来 日志日志日志，重要的事情说三遍！！！
tail -f /var/log/nginx/error.log 
```
___
证书生成了、服务器配置好了，那就在浏览器看看。

![secure](http://upload-images.jianshu.io/upload_images/1678789-8fc02dad0233daf0.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
PS:生成的证书，即使域名解析到了其它的IP照样可以使用，适合局域网内SSL。

Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
