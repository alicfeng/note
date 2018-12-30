**简洁而言：**
> 必须安装了vmware-tool工具才可以正常使用文件共享的功能
- 安装增强功能
> 桌面版点点鼠标即可，说说Server版本的。

```shell
mkdir /mnt/cdrom 
mount /dev/cdrom /mnt/cdrom  
cd /mnt/cdrom
sudo cp VMwareTools-10.0.5-3228253.tar.gz /mnt/VMwareTools-10.0.5-3228253.tar.gz
cd /mnt
tar -zxvf  VMwareTools-10.0.5-3228253.tar.gz 
```
___

- 无法查看共享的目录
```shell
#在刚解压的目录下执行
sudo mount -t vmhgfs .host :/ /mnt/hgfs/
```
