**前言回忆**
今天早上在开发项目的时候，string怎么就不能转成json呢，String是没有问题的，但是json_decode无论怎样都是返回null。好了，既然String的格式是没有问题的，那就是你Json对String内容的限制的问题，果然，是的！

___
**json_decode要求的字符串比较严格：**
- 使用UTF-8编码 
- 不能在最后元素有逗号
- 不能使用单引号
- 不能有\r,\t,\n，如果有请替换

___
**一个有趣的解决方案**
~~~
#去除某些限制的字符
$result = json_decode(trim($contents,chr(239).chr(187).chr(191)),true);
~~~
~~~
#去除某些限制的字符 以及将换行替换，为了后面再将换行再现！
$journey = json_decode(str_replace("\n", "<br>", trim($_POST["journey"], chr(239) . chr(187) . chr(191))), true);
~~~
