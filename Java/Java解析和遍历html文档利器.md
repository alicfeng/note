前言：几乎任何的语言都可以解析和遍历html超文本，我常用的语言就是php啦，但是我想在android客户端获取网络http的的数据，虽然可以使用php但是需要二次连接和php环境，然而就直接使用java语言去搞，那么不可能直接用java原生语言去码的啦，使用**Jsoup**去解析，Jsoup是java语言一款不错的html解析文档的利器！
___
**Jsoup的简介**
Jsoup是java语言一款不错的html解析和遍历文档的利器。
___
**Jsoup的优点**
其解析器能够尽最大可能从你提供的HTML文档来创见一个干净的解析结果，无论HTML的格式是否完整。比如它可以处理：
~~~
没有关闭的标签 
 <p>Lorem <p>Ipsum parses to <p>Lorem</p> <p>Ipsum</p>

~~~
~~~
隐式标签 
 <td>Table data</td>包装成<table><tr><td>
~~~
~~~
创建可靠的文档结构（html标签包含head 和 body，在head只出现恰当的元素）
~~~
**Jsoup常用的方法**
从一个URL加载一个Document
~~~
简单的get方法
Document doc = Jsoup.connect("http://www.domain.com/").get();
String title = doc.title();
~~~
~~~
带头信息的post方法
Document doc = Jsoup.connect("http://www..domain.com")  
                  .data("username", "Alic")  
                  .userAgent("Mozilla")  
                  .cookie("auth", "token")  
                  .timeout(3000)  
                  .post();
~~~
从文件中加载HTML文档
~~~
File file = new File("path");
Document doc = Jsoup.parse(file, "UTF-8", "http://www.domian.com/");
~~~
简单的从String加载HTML
~~~
Document doc = Jsoup.parse(String html);
~~~
使用DOM方法来遍历一个文档
~~~
File file = new File("/path/index.html");
Document doc = Jsoup.parse(file, "UTF-8", "http://www.domian.com/");
Element content = doc.getElementById("content");//获取id为content的dom节点
Elements links = content.getElementsByTag("a");//获取所有的a标签dom节点
//遍历所有的a标签
for (Element link : links) {  
      String linkHref = link.attr("href");  
      String linkText = link.text();
}
Elements links = doc.select("a[href]"); //带有href属性的a元素
Elements pngs = doc.select("img[src$=.png]");
  //扩展名为.png的图片
Element masthead = doc.select("div.masthead").first();
  //class等于masthead的div标签
Elements resultLinks = doc.select("h3.r > a"); //在h3元素之后的a元素
~~~
常用的方法：见官网API文档[传送Jsoup](http://www.open-open.com/jsoup/parsing-a-document.htm)













