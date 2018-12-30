**openpyxl简介**
还是简单一句：顾名思义，openpyxl就是一个处理excel文档的一个python库。
___
**openpyxl信息**
[openpyxl地址传送](https://pypi.python.org/pypi/openpyxl)
openpyxl依赖jdcal以及et_xmlfile依赖库
[jdcal地址](https://pypi.python.org/pypi/jdcal)
[et_xmlfile地址](https://pypi.python.org/pypi/et_xmlfile)
___
**openpyxl安装**
~~~
#pip安装
sudo pip install openpyxl
#源码编译
python setup.py install
~~~
对于如何使用pip安装传送[pip教程]()，源码编译安装呢，下载路径已经在上面了
每次编辑到关于安装的好浪费时间，but~~
___
创建一个工作簿
~~~
wb = workbook()
~~~

加载已存在excel文件
~~~
filePath = "/data/alic/demo.xlsx"
wb = load_workbook(filename=filePath)
~~~

选中sheet
~~~
# 选择默认的sheet
ws = wb.active

# 通过索引加载sheet index从0开始
ws = wb.worksheets[index]

# 通过sheet名加载 感觉有问题，中文？
ws = wb.get_sheet_by_name()
# 这个没有问题
ws = wb["name"]
~~~

创建sheet
~~~
#默认插在工作簿末尾
ws = wb.create_sheet() 
# or
# 插入在工作簿的指定位置位置 index从0开始
ws = wb.create_sheet(index) 
~~~

更改sheet的名字
~~~
# 新建默认的话 sheet0 sheet1 ...
ws.title = "hello"
~~~

获取sheet的名称
~~~
sheet_name = wb.get_sheet_names()
print sheet_name
# or
for sheet in wb:
    print sheet.title
~~~

单元格操作
~~~
# 获取一个单元格的value
value = ws['B2']
# or
value = ws.cell('B2')
# or 非常推荐 遍历都很方便
value = ws.cell(row=1,column=2)

#获取多个单元格
cells = ws['A1':'E4']

#为一个单元格赋值
 ws['B2'] = "alic"
# or
ws.cell('B2') = "hello"
# or 非常推荐 遍历都很方便
ws.cell(row=1,column=2) = "value"

# 遍历多个单元格
for row in ws.iter_rows('A1:D2'):
      for cell in row: 
            print cell
~~~

获取当前工作表的已有数据的对象
~~~
# 所有行
ws.rows

# 所有列
ws.columns
~~~

获取当前工作表的数据长度与宽度
~~~
row_length = len(ws.rows)
cloumn_length = len(ws.columns)
# 推荐 centOS上面的会报错
row-length = len(list(ws.rows))
cloumn_length = len(list(ws.rows))

~~~
___
保存文件
~~~
# 注意要是加载进来的路径与保存的路径一致文件将会被覆盖
wb.save(path)

# 也可以将文件作为模板保存  as_template默认为False
wb.save('document_template.xltx', as_template=True)
~~~

简单的样式处理
~~~
# 文本对齐方式
align = Alignment(horizontal='center', vertical='center')
ws.cell(row=deng_lu_taskRow, column=index + 3).alignment = align

# 字体大小
font = Font(size=10)
ws.cell(row=taskRow, column=column).font = font
~~~
[具体样式Click](http://blog.csdn.net/Jmilk/article/details/50444829)

___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
