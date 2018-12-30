**前言**
thinkphp官方api常不更新，thinkphp-code更新，然而api却不更新。诸多原因，即使现在thinkphp-5.+。
___

**Step**
1.将CheckLangBehavior.class.php（完整版跳过）文件放到此目录下：\ThinkPHP\Library\Behavior

2.修改目录下文件Application\Home\Conf\tags.php（没有此文件的话自己添加）添加配置：
~~~
　　return array(
        'app_begin' => array('Behavior\CheckLangBehavior'),
　　);
~~~
3.修改Application\Home\Conf\config.php文件，添加配置如下：
~~~
return array(
    //'配置项'=>'配置值'
    'LANG_SWITCH_ON' => true,   // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST'        => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
);
~~~
4.在目录Application\Home下添加Lang目录，并在Lang目录下，添加zh-cn或者en-un等语言目录，在每种语言目录下可以以模块名为文件名建多语言文件

　　如：index模块 的en-un语言的文件名：index.php

　　index.php的内容如下：
~~~
　　return array(
        'lan_define'=>'welcome use ThinkPHP',
    );
~~~

5.控制器中直接使用L来调用人，如：L('lan_define');
~~~
//模板中这样调用：
<h3>{$Think.lang.lan_define}</h3>
~~~


