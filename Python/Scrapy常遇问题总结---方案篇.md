- **爬取任务时，有些URL被拒绝，出现如下的结果**
`[scrapy.downloadermiddlewares.robotstxt] DEBUG: Forbidden by robots.txt:`
**解决方案**
在settings.py配置文件设置一个配置项即可
```
# Obey robots.txt rules
ROBOTSTXT_OBEY = False
```
___
