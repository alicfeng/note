---
title: RAID磁盘阵列-Redundant Arrays of Independent Disks
date: 2017-03-29
tags:
  - RAID
categories: 硬件运维
---



`RAID` 英文 `Redundant Arrays of Independent Disks`，汉语翻译即磁盘阵列。最初是由加利福尼亚大学伯克利分校在1988年发表的，旨在效能与成本。简单来介绍，`RAID` 是利用多块物理硬盘来组成一个虚拟硬盘，并由这些虚拟的硬盘组成一个矩阵的存储系统的一种技术。它的目的很简单却很重要，毕竟关系到数据，保证数据的安全性、提高数据读写的效率。磁盘阵列主要分类三种：  `外接式磁盘矩阵列柜`、`内接式磁盘矩阵列卡`、`软件模拟仿真`。
外接式磁盘矩阵列柜具有可热交换的特性，几乎用在大型的服务器上，但是呢，这种类型的模式搭建的成本还是很高的... ...。我还是说说 `RAID` 常用的级别以及复合类型。

<!-- more -->

___
**RAID 0**
说啥也不够一张图清楚，快看O(∩_∩)O哈哈~，没有太对的时间，看图了事，一切简述O(∩_∩)O

![RAID 0](http://upload-images.jianshu.io/upload_images/1678789-05957e5275eb1c65.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
特点：
至少有两块才能组建RAID 0
优点：
1) 没有数据冗余
2) 读写速度快，read>write
缺点：
1) 安全性低，一旦其中一块硬盘故障，数据将全毁
___
**RAID 1**

![RAID 1](http://upload-images.jianshu.io/upload_images/1678789-ebdbde0e878be2e7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

特点：
Mirror镜像磁盘阵列，只需要2块硬盘组建。
优点：
1) 安全性高，支持热恢复
缺点：
1) 成本高
2) 虚拟硬盘可用容量是总容量的一半
3) 读写速度慢
___
**RAID 5**
RAID 5是无独立校验盘的奇偶校验磁盘阵列。至少需要3块以上物理硬盘组建，比如一共有N(N>3)块虚拟硬盘，要存储的数据将被分割分别写入阵列的N-1块虚拟硬盘，而剩下的一块虚拟硬盘将会写入校验数据，允许在一块物理硬盘出错的情况下恢复重建RAID 5，保证数据不丢失。
RAID 5虽是从RAID 3和RAID 4发展而来，但其更多像RAID 0与RAID 1的结合。与RAID 0接近的数据传输速度，有类RAID 1的数据安全保护。比起其他RAID在有冗余安全保护下可使用容量最多。

![RAID 5](http://upload-images.jianshu.io/upload_images/1678789-4c1eda16cfc78c72.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

**RAID 6**
RAID 6 与RAID 5 很类似，6的话比5多一个校验数据虚拟硬盘，在此就不多说了。
___

**RAID 1+0与RAID 0+1**
RAID 1+0与RAID 0+1都是一种复合的磁盘矩阵，复合磁盘矩阵就是将2种不同RAID级别组合在一起，组成一个兼具2种RAID特性的新RAID级别。RAID 1+0与RAID 0+1两者的原理都是一样的，在RAID 1+0以及RAID 0+1的复合类型中呢，具备了RAID0和RAID1的优点：数据的读写速度快、安全性高，但是呢，复合型的磁盘矩阵的成本很高。下面是RAID 1+0与RAID 0+1的图解。

![RAID 1+0](http://upload-images.jianshu.io/upload_images/1678789-150a20e16d612dbc.png)


![RAID 0+1](http://upload-images.jianshu.io/upload_images/1678789-1428198967ae61d8.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___
___至于更多的可以自行了解... ...
推荐一片简文[PC存储方式解析-RAID篇-理论章](http://www.jianshu.com/p/a471df0f3260)
 **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
