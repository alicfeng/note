**前言**
天黑之后就在图书馆玩一个爬虫，就是那个开源的爬虫 -- scrapy！早几天就搭建了一个Redis集群服务器，于是就将爬取的数据存储于Redis数据库。
[Redis数据库集群搭建 | 实践篇](http://www.jianshu.com/p/29166019658f)
___
**Scrapy**
Scrapy是一个为了爬取网站数据，提取结构性数据而编写的应用框架。 可以应用在包括数据挖掘，信息处理或存储历史数。Scrapy 使用 Twisted这个异步网络库来处理网络通讯，架构清晰，并且包含了各种中间件接口，可以灵活的完成各种需求。
___
**目的**
目标是学校图书馆的热榜书籍，内网首选[ 省流量O(∩_∩)O哈哈~ ]。
将热榜书籍的相关数据存储到Reids数据库即可，很简单的一个实验
PS
```
# 安装python-redis
sudo pip install python-redis
```
___
**一切就绪**`前提已经掌握helloworld`
 - 关闭ROBOTSTXT_OBEY
编辑`settings.py`，不然有些URL拒绝访问。
```
# Obey robots.txt rules
ROBOTSTXT_OBEY = False
```

 - 定义Item
编辑items.py，该文件就是用于定义对象的。此时我们定义书籍的对象。
```
class BookItem(scrapy.Item):
    bid = scrapy.Field()  # 序号
    name = scrapy.Field()  # 书名
    author = scrapy.Field()  # 作者
    kid = scrapy.Field()  # 索引号
    isbn = scrapy.Field()  # isbn
    public_location = scrapy.Field()  # 出版社
    public = scrapy.Field()  # 出版地
    clicked = scrapy.Field()  # 浏览次数
    type = scrapy.Field()  # 书籍类型
```

 - 编辑爬虫Spider程序
在spiders文件夹新建一个BookSpider.py文件，用户爬取数据逻辑的文件，获取书籍的信息并存储到Redis，核心程序！
内容如下：

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import scrapy
import redis

from demo01.items import BookItem


class BookSpider(scrapy.Spider):
    # Spider的名字 | 唯一的
    name = "books"
    # 允许爬取的域名
    # allowed_domains = ["samego.com"]
    # 爬取的域名
    start_urls = [
        "http://172.16.4.188:8081/opac/index_hotll.jsp/"
    ]

    # 开始执行任务 | parse属于Spider的一个方法
    def parse(self, response):
        # 定义redis线程池
        pool = redis.ConnectionPool(host='172.16.168.1', port=6379)
        presenter = redis.Redis(connection_pool=pool)

        # 有关书籍的表格
        book_table = response.xpath('//table[@class="bordermain"][1]')

        # 获取每一本书的集合tr
        book_elements = book_table.xpath(".//tr")
        # 删除第一行的tr
        del book_elements[0]

        # 遍历处理数据
        for book_tr in book_elements:
            # 定义书籍对象
            book_item = BookItem()

            # 获取各本书籍的信息
            book = book_tr.xpath(".//td")
            book_item["bid"] = book[1].xpath("./text()").extract()
            book_item["name"] = book[2].xpath("./text()").extract()
            book_item["author"] = book[3].xpath("./text()").extract()
            book_item["kid"] = book[4].xpath("./text()").extract()
            book_item["isbn"] = book[5].xpath("./text()").extract()
            book_item["public_location"] = book[6].xpath("./text()").extract()
            book_item["public"] = book[7].xpath("./text()").extract()
            book_item["clicked"] = book[9].xpath("./text()").extract()
            book_item["type"] = book[10].xpath("./text()").extract()

            # 设置有序集合键值
            z_key = '%s_%s' % ('book', book_item["bid"][0])
            # 将数据保存redis
            presenter.zadd(z_key, book_item["name"], 1)
            presenter.zadd(z_key, book_item["author"], 2)
            presenter.zadd(z_key, book_item["name"], 3)
            presenter.zadd(z_key, book_item["kid"], 4)
            presenter.zadd(z_key, book_item["isbn"], 5)
            presenter.zadd(z_key, book_item["public_location"], 6)
            presenter.zadd(z_key, book_item["public"], 7)
            presenter.zadd(z_key, book_item["clicked"], 8)
            presenter.zadd(z_key, book_item["type"], 9)

            yield book_item
```
 - 执行scrapy的程序

```
➜  ~ scrapy crawl books

# or 将数据以json的形式保存在books.json
➜  ~ scrapy crawl books -o books.json
```
- 终端运行 `部分返回如下`

```
➜  demo01 scrapy crawl books
2017-04-19 21:45:45 [scrapy.utils.log] INFO: Scrapy 1.3.3 started (bot: demo01)
... ...
2017-04-19 21:45:46 [scrapy.core.engine] DEBUG: Crawled (200) <GET http://172.16.4.188:8081/opac/index_hotll.jsp/> (referer: None)
2017-04-19 21:45:47 [scrapy.core.scraper] DEBUG: Scraped from <200 http://172.16.4.188:8081/opac/index_hotll.jsp/>
{'author': ['杨萃先 ... [等]著\xa0'],
 'bid': ['1'],
 'clicked': ['14987\xa0'],
 'isbn': ['978-7-80080-752-7\xa0'],
 'kid': ['C913.2/258\xa0'],
 'name': ['\xa0'],
 'public': ['群言出版社\xa0'],
 'public_location': ['北京\xa0'],
 'type': ['中文图书\xa0']}
2017-04-19 21:45:47 [scrapy.core.scraper] DEBUG: Scraped from <200 http://172.16.4.188:8081/opac/index_hotll.jsp/>
{'author': ['(英)霭理士(Havelock Ellis)著\xa0'],
 'bid': ['2'],
 'clicked': ['1219\xa0'],
 'isbn': ['7-108-00161-6\xa0'],
 'kid': ['R167/20\xa0'],
 'name': ['\xa0'],
 'public': ['三联书店\xa0'],
 'public_location': ['北京\xa0'],
 'type': ['中文图书\xa0']}
... ...
```
注意：还有一点问题，存在unicode编码的字符，编码处理不难，可是图书馆又准备关门了。得跑路啦O(∩_∩)O哈哈~
___
Alic say :**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
