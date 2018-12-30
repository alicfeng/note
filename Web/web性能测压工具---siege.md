**简介**
[Siege](http://www.joedog.org/siege-home/)是一个压力测试和评测工具，设计用于WEB开发这评估应用在压力下的承受能力：可以根据配置对一个WEB站点进行多用户的并发访问，记录每个用户所有请求过程的相应时间，并在一定数量的并发访问下重复进行。 Siege 支持基本的认证，cookies， HTTP 和 HTTPS 协议。
___
**安装**
- debian/ubuntu
```
sudo apt-get install siege
```
___

- 语法格式
```
siege [选项]
siege [选项] URL
siege -g URL
```
- 选项
```
  -C, --config              显示当前的默认配置
  -v, --verbose             详细通知打印到屏幕
  -g, --get                 GET的方式
  -c, --concurrent=NUM      并发量10
  -i, --internet            INTERNET user simulation, hits URLs randomly.
  -b, --benchmark           BENCHMARK: no delays between requests.
  -t, --time=NUMm           TIMED testing where "m" is modifier S, M, or H
                            ex: --time=1H, one hour test.
  -r, --reps=NUM            访问次数
  -f, --file=FILE           选择URL文件
  -R, --rc=FILE             RC, specify an siegerc file
  -l, --log[=FILE]          指定日志文件，默认/var/siege.log
  -m, --mark="text"         标记，用于日志
  -d, --delay=NUM           延迟请求
  -H, --header="text"       请求头部
  -A, --user-agent="text"   请求代理
  -T, --content-type="text" 请求内容
```

- 示例
场合：测试URL为git.samego.com、并发量为100、访问次数为10

```
➜  ~ sudo siege git.samego.com -c 100 -r 10
** SIEGE 3.0.5
** Preparing 100 concurrent users for battle.
The server is now under siege..      done.

Transactions:		        1000 hits
Availability:		      100.00 %
Elapsed time:		       27.32 secs
Data transferred:	        2.25 MB
Response time:		        1.34 secs
Transaction rate:	       36.60 trans/sec
Throughput:		        0.08 MB/sec
Concurrency:		       48.98
Successful transactions:        1000
Failed transactions:	           0
Longest transaction:	       19.43
Shortest transaction:	        0.01
 
FILE: /var/log/siege.log
You can disable this annoying message by editing
the .siegerc file in your home directory; change
the directive 'show-logfile' to false.
```
____
除了sisge测压工具，还有很多的开源测压工具，比如
**[Grinder](http://grinder.sourceforge.net/)**
**[Pylot](http://www.pylot.org/)** 
[**Web Capacity Analysis Tool (WCAT)**](http://www.iis.net/community/default.aspx?tabid=34&i=1466&g=6)**
[fwptt](http://fwptt.sourceforge.net/index.html)**
**[JCrawler](http://jcrawler.sourceforge.net/)** 
**[Apache JMeter](http://jakarta.apache.org/jmeter/)**
**[http_load](http://www.acme.com/software/http_load/)**
**[Web Polygraph](http://www.web-polygraph.org/)**
**[OpenSTA](http://opensta.org/)**

**感谢[十个免费的WEB压力测试工具](http://coolshell.cn/articles/2589.html)**









