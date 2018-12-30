**elfinder简介：**
elfinder是一款支持在线文件管理的系统服务，基于php语言开发，采用jquery-JS与jquery-UI库，并且能支持多国语言，最大的好处就是开源的。
___
**elfinder安装**
elfinder的安装极其的简易，只需要下载解压即可，传送[Download](http://studio-42.github.io/elFinder)
- 将其解压放在服务器部署映射的目录下
- 将php文件夹下面的connector.minimal.php-dist重命名位connector.minimal.php
至此已经完成安装！

![效果图](http://upload-images.jianshu.io/upload_images/1678789-bd93c57c041698da.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**elfinder相关配置**
(1)将默认语言设置位中文
引入js/i18n文件夹下的elfinder.zh_CN.js中文js文件即可，修改index.html【我将elfinder.html重命名位index.html】
~~~
<!-- elFinder translation (OPTIONAL) -->
        //第一，引入elfinder.zh_CN.js文件。该处默认已经注释了
		<script src="js/i18n/elfinder.zh_CN.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			$(document).ready(function() {
				$('#elfinder').elfinder({
					url : 'php/connector.minimal.php'  // connector URL (REQUIRED)
					 , lang: 'zh_CN'                    // language (OPTIONAL)第二，默认已经注释了，语言选择说明
				});
			});
		</script>
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**











