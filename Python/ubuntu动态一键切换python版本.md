**前言**
ubuntu14.+python默认是已经安装了python2 python2.7 python3 python3.4的，但是最常用的就是python2.7以及python3.4。某些时候会使用不同的版本，因此需要切换其版本。
于是搞了一个动态脚本加载python版本以及动态切换其版本的shell脚本。挺方便的：一键查看与修改！
___
时日不多，赶紧用python！
昨晚失眠，起来写脚本，然而文章就诞生了！
___
**解决方案**
~~~
#安全备份
sudo cp /usr/bin/python /usr/bin/python_default
#切换版本 实质上就是创建软链
sudo ln -s /usr/bin/python3.4 /usr/bin/python
~~~
___
**动态一键切换python版本**
~~~
#!/bin/bash

#--------config----------start
#备份目录
pythonDir="/usr/bin/pythonAlic/"
#--------config----------end


index=0
pythonarray[0]="null"

if [ ${UID} == 0 ];then
	echo "请选择您要切换python的版本:"
	echo "1. 初始化程序与备份"
	#判断配置目录是否存在
	if [ -x $pythonDir ];then
		#遍历目录下的文件----------start
		dir=$(ls -l ${pythonDir} |awk '{print $NF}')
		for i in $dir
		do
			#过滤文件----------start
			((index++))
			if [ $index -eq 1 ];then
				continue
			else
				after=${i:0-1}
				if [ "$after" -gt 0 ] 2>/dev/null ;then
					str="${index}. 切换${i}"
					#echo $str
					pythonarray[$index]=$str
					echo ${pythonarray[$index]}
				else
					((index--))
				fi
			fi
			#过滤文件----------end
		done
	else
		echo "程序首次运行，请先执行1选项"
	fi
	#遍历目录下的文件----------end
	echo "------------------------------"
	#开始操作
	read -p "请选择您要切换python的版本:" option
	
	if [ $option == 1 ]; then
		if [ -x $pythonDir ]; then
			rm -rf $pythonDir	
			echo "重置目录成功"
		fi
		mkdir $pythonDir	
		echo "${pythonDir}python_default"
		`cp /usr/bin/python "${pythonDir}python_default"`
		`cp /usr/bin/python* "${pythonDir}"`
		echo "备份文件完成"
	fi
	for ((i=1;i<=${index};i++));
	do
		key=${pythonarray[$i]:0:1}
		#echo $key
		if [ "${option}" == "${key}" ]; then
			#开始切换版本操作----------start
			pyname=${pythonarray[$i]:5}
			rm /usr/bin/python
			ln -s /usr/bin/$pyname /usr/bin/python
			echo "版本已经切换至$pyname"
			#开始切换版本操作----------end
		fi
	done
else
	echo "您没有权限~~~"
fi
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-390216c47eb70fe6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**一键切换脚本**
这个就没有什么用了，之前写的一个脚本，非动态性！不推荐。
~~~
#!/bin/bash

if [ ${UID} == 0 ];then
	echo "请选择您要切换python的版本:"
	echo "0. 推荐备份默认版本"
	echo "1. python2.7"
	echo "2. python3.4"
	echo "------------------------------"
	read -p "请选择您要切换python的版本:" option
	case $option in
		0)
		cp /usr/bin/python /usr/bin/python_default
		echo "备份完成"
		;;
		1)
		echo "正在切换python至2.7版本"
		rm -f /usr/bin/python
		ln -s /usr/bin/python2.7 /usr/bin/python 
 	       	echo "change completed"
		;;
		2)
		echo "正在切换python至3.4版本"
                rm -f /usr/bin/python
                ln -s /usr/bin/python3.4 /usr/bin/python
        echo "change completed"
		;;
		*)
		echo "输入不正确~~~"
		;;
	esac
else
	echo "您没有权限~~~"
fi
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
