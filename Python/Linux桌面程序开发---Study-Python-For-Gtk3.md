**背景：**

​	使用Linux系统已经有一段时间了，在管理系统是几乎都是使用命令行与内核交流的，使用虽多的就是Shell，其次就是python。这两天突然心血来潮，想到了Linux PC端桌面程序，在我个人的熟悉语言中呢，python比较适合，不过、开发Linux桌面我只是玩玩的。对于开发Linux桌面程序掌握Python的推荐使用Python Gtk3。

​	想玩出一个Linux基本桌面程序( 几乎没有业务逻辑 )，看完下面的( 重点是图片 | UI组件 )，大概就有一个底了！

___

* 1、入门Hello word

`源码code`

```
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

# 定义我的hello窗口
class Application(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Hello word")

# 实例化
app = Application()
app.show_all()
Gtk.main()
```
`执行execute`

![Hello word](http://upload-images.jianshu.io/upload_images/1678789-0ea2ecea2864f081.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___

* 2-1、布局之boxes布局


`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class BoxesContainer(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="BoxesContainer")
        # 定义一个盒子
        self.box = Gtk.Box(spacing=6)
        # 将盒子布局在窗口
        self.add(self.box)
        # 定义两个按钮并放置于盒子
        self.button1 = Gtk.Button(label="Hello")
        self.button1.connect("clicked", self.say_hello)
        self.box.pack_start(self.button1, True, True, 0)

        self.button2 = Gtk.Button(label="Goodbye")
        self.button2.connect("clicked", self.say_goodbye)
        self.box.pack_start(self.button2, True, True, 0)

    @staticmethod
    def say_hello(widget):
        print("Hello")

    @staticmethod
    def say_goodbye(widget):
        print("Goodbye")


win = BoxesContainer()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![BoxesContainer](http://upload-images.jianshu.io/upload_images/1678789-ddf5c729e427aa5b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)



- 2-2、布局之卡片式布局

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class GridContainer(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="GridContainer")
        # 定义一个卡片
        grid = Gtk.Grid()
        # 将卡片放置于窗口
        self.add(grid)

        # 定义按钮将布置于卡片上
        button1 = Gtk.Button(label="Button 1")
        button2 = Gtk.Button(label="Button 2")
        button3 = Gtk.Button(label="Button 3")
        button4 = Gtk.Button(label="Button 4")
        button5 = Gtk.Button(label="Button 5")
        button6 = Gtk.Button(label="Button 6")

        grid.add(button1)
        # 指定具体位置
        grid.attach(button2, 1, 0, 2, 1)
        # 相对布局
        grid.attach_next_to(button3, button1, Gtk.PositionType.BOTTOM, 1, 2)
        grid.attach_next_to(button4, button3, Gtk.PositionType.RIGHT, 2, 1)
        grid.attach(button5, 1, 2, 1, 1)
        grid.attach_next_to(button6, button5, Gtk.PositionType.RIGHT, 1, 1)


win = GridContainer()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![GridContainer](http://upload-images.jianshu.io/upload_images/1678789-b2a209e3d0dd531d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

- 2-3、布局之list布局

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

# 继承Gtk.ListBoxRow
class ListBoxRowWithData(Gtk.ListBoxRow):
    def __init__(self, data):
        super(Gtk.ListBoxRow, self).__init__()
        self.data = data
        self.add(Gtk.Label(data))


class ListBoxWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="ListBoxContainer")
        # 设置窗口宽度
        self.set_border_width(10)

        # 定义一个盒子桥梁 | 垂直排列 | 间隔为6
        box_outer = Gtk.Box(orientation=Gtk.Orientation.VERTICAL, spacing=6)
        self.add(box_outer)

        # 定义一个list容器
        listbox = Gtk.ListBox()
        listbox.set_selection_mode(Gtk.SelectionMode.NONE)
        box_outer.pack_start(listbox, True, True, 0)

        # 定义一个行箱子
        row = Gtk.ListBoxRow()
        # 定义一个原子盒子 | 水平装产品
        box1 = Gtk.Box(orientation=Gtk.Orientation.HORIZONTAL, spacing=50)

        # 定义标签
        internal_time_label = Gtk.Label("是否自动对齐网络时间", xalign=0)
        # 定义一个开关按钮
        switch = Gtk.Switch()
        switch.props.valign = Gtk.Align.CENTER

        # 装箱
        box1.pack_start(internal_time_label, True, True, 0)
        box1.pack_start(switch, False, True, 0)
        row.add(box1)
        listbox.add(row)

        # 定义ListBoxRow
        row = Gtk.ListBoxRow()
        # 定义一个Box | 水平布局
        h_box = Gtk.Box(orientation=Gtk.Orientation.HORIZONTAL, spacing=50)

        label = Gtk.Label("日期格式", xalign=0)
        combo = Gtk.ComboBoxText()
        combo.insert(0, "0", "24-hour")
        combo.insert(1, "1", "AM/PM")

        h_box.pack_start(label, True, True, 0)
        h_box.pack_start(combo, False, True, 0)
        row.add(h_box)
        listbox.add(row)

        # 在定义一个ListBox
        listbox_2 = Gtk.ListBox()

        items = ["PHP", "Python", "Shell"]

        for item in items:
            listbox_2.add(ListBoxRowWithData(item))

        box_outer.pack_start(listbox_2, True, True, 0)


win = ListBoxWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()

```

`执行excute`

![ListBoxContainer](http://upload-images.jianshu.io/upload_images/1678789-2166cbc2bfa89ef3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)



___

**2-4、StackSwitcher**

`源码code`

```
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class StackWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="StackWindow")
        self.set_border_width(10)

        vbox = Gtk.Box(orientation=Gtk.Orientation.VERTICAL, spacing=6)
        self.add(vbox)

        # 定义Stack
        stack = Gtk.Stack()
        stack.set_transition_type(Gtk.StackTransitionType.SLIDE_LEFT_RIGHT)
        # 动画时长1s
        stack.set_transition_duration(1000)

        zone_1 = Gtk.Label("世界上最好的语言 没有之一")
        stack.add_titled(zone_1, "说明", "PHP")

        zone_2 = Gtk.Label("时日不多 赶紧使用Python")
        stack.add_titled(zone_2, "说明", "Python")

        stack_switcher = Gtk.StackSwitcher()
        stack_switcher.set_stack(stack)
        vbox.pack_start(stack_switcher, True, True, 0)
        vbox.pack_start(stack, True, True, 0)


win = StackWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![StackSwitcher](http://upload-images.jianshu.io/upload_images/1678789-8135e4a810b96227.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**2-5、HeaderBar**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi
from gi.overrides.Gio import Gio

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class HeaderBarWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="HeaderBar")
        self.set_border_width(10)
        self.set_default_size(400, 300)

        # 定义HeaderBar
        hb = Gtk.HeaderBar()
        # 隐藏原有的工具按钮
        hb.set_show_close_button(False)
        hb.props.title = "HeaderBar"
        self.set_titlebar(hb)

        button = Gtk.Button()
        icon = Gio.ThemedIcon(name="mail-send-receive-symbolic")
        image = Gtk.Image.new_from_gicon(icon, Gtk.IconSize.BUTTON)
        button.add(image)
        # 放置于HeaderBar左边
        hb.pack_end(button)

        box = Gtk.Box(orientation=Gtk.Orientation.HORIZONTAL)
        Gtk.StyleContext.add_class(box.get_style_context(), "linked")

        button = Gtk.Button()
        button.add(Gtk.Arrow(Gtk.ArrowType.LEFT, Gtk.ShadowType.NONE))
        box.add(button)

        button = Gtk.Button()
        button.add(Gtk.Arrow(Gtk.ArrowType.RIGHT, Gtk.ShadowType.NONE))
        box.add(button)
        # 放置于HeaderBar左边
        hb.pack_start(box)

        self.add(Gtk.TextView())


win = HeaderBarWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![HeaderBar](http://upload-images.jianshu.io/upload_images/1678789-99a26898163750cc.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**2-6、FlowBox**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class FlowBoxWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="FlowBox Demo")
        self.set_border_width(10)
        self.set_default_size(300, 250)

        # HeaderBar
        header = Gtk.HeaderBar(title="Flow Box")
        header.set_subtitle("Sample FlowBox app")
        header.props.show_close_button = True
        self.set_titlebar(header)

        # 滑动条
        scrolled = Gtk.ScrolledWindow()
        scrolled.set_policy(Gtk.PolicyType.NEVER, Gtk.PolicyType.AUTOMATIC)

        flow_box = Gtk.FlowBox()
        flow_box.set_valign(Gtk.Align.START)
        # 每行最大数量
        flow_box.set_max_children_per_line(30)
        flow_box.set_selection_mode(Gtk.SelectionMode.NONE)

        # 随便添加content
        for item in range(0, 20):
            flow_box.add(Gtk.Button(item))

        scrolled.add(flow_box)
        self.add(scrolled)


win = FlowBoxWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![FlowBox](http://upload-images.jianshu.io/upload_images/1678789-f7df53c4f3b31295.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**2-7、NoteBook**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class MyWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Simple Notebook Example")
        self.set_border_width(3)

        # 定义一个NoteBook
        self.notebook = Gtk.Notebook()
        self.add(self.notebook)

        # Notebook的一个item
        self.page1 = Gtk.Box()
        self.page1.set_border_width(10)
        self.page1.add(Gtk.Label('PHP'))
        self.notebook.append_page(self.page1, Gtk.Label('最好的编程语言'))

        self.page2 = Gtk.Box()
        self.page2.set_border_width(10)
        self.page2.add(Gtk.Label('HTML'))
        self.notebook.append_page(self.page2, Gtk.Label('标签性超文本'))


win = MyWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![NoteBook](http://upload-images.jianshu.io/upload_images/1678789-d1be38d76ce16329.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**3、输入框Entry**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi
from gi.overrides.GObject import GObject

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class EntryWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Entry Demo")
        self.set_size_request(200, 100)
        self.set_border_width(10)

        self.timeout_id = None

        vbox = Gtk.Box(orientation=Gtk.Orientation.VERTICAL, spacing=6)
        self.add(vbox)

        self.entry = Gtk.Entry()
        self.entry.set_text("AlicFeng")
        vbox.pack_start(self.entry, True, True, 0)

        h_box = Gtk.Box(spacing=6)
        vbox.pack_start(h_box, True, True, 0)

        self.check_editable = Gtk.CheckButton("可编辑")
        self.check_editable.connect("toggled", self.on_editable_toggled)
        self.check_editable.set_active(True)
        h_box.pack_start(self.check_editable, True, True, 0)

        self.check_visible = Gtk.CheckButton("可看见")
        self.check_visible.connect("toggled", self.on_visible_toggled)
        self.check_visible.set_active(True)
        h_box.pack_start(self.check_visible, True, True, 0)

        self.icon = Gtk.CheckButton("Icon")
        self.icon.connect("toggled", self.on_icon_toggled)
        self.icon.set_active(True)
        h_box.pack_start(self.icon, True, True, 0)

    def on_editable_toggled(self, button):
        value = button.get_active()
        self.entry.set_editable(value)

    def on_visible_toggled(self, button):
        value = button.get_active()
        self.entry.set_visibility(value)

    def on_icon_toggled(self, button):
        if button.get_active():
            icon_name = "system-search-symbolic"
        else:
            icon_name = None
        self.entry.set_icon_from_icon_name(Gtk.EntryIconPosition.PRIMARY,
                                           icon_name)


win = EntryWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Entry](http://upload-images.jianshu.io/upload_images/1678789-a6de1ebfd397282c.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4-1、Button**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class ButtonWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Button Demo")
        self.set_border_width(10)

        h_box = Gtk.Box(spacing=6)
        self.add(h_box)

        button = Gtk.Button.new_with_label("Submit")
        button.connect("clicked", self.submit_handler)
        h_box.pack_start(button, True, True, 0)

        button = Gtk.Button.new_with_mnemonic("打开")
        button.connect("clicked", self.open_handler)
        h_box.pack_start(button, True, True, 0)

        button = Gtk.Button.new_with_mnemonic("关闭")
        button.connect("clicked", self.close_handler)
        h_box.pack_start(button, True, True, 0)

    @staticmethod
    def submit_handler(button):
        print "submit_handler"

    @staticmethod
    def open_handler(button):
        print "open"

    @staticmethod
    def close_handler(button):
        Gtk.main_quit()


win = ButtonWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Button](http://upload-images.jianshu.io/upload_images/1678789-e08d4c9a2f81c3c5.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4-2、ToggleButton**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class ToggleButtonWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="ToggleButton Demo")
        self.set_border_width(10)

        # 定义基本盒子
        basic_box = Gtk.Box(spacing=6)
        self.add(basic_box)

        # 定义一个toggle按钮
        button = Gtk.ToggleButton("点击试试")
        button.connect("toggled", self.toggle_handler, "1")
        button.set_active(True)
        basic_box.pack_start(button, True, True, 0)

    @staticmethod
    def toggle_handler(button, name):
        if button.get_active():
            print "active"
        else:
            print "not active"


win = ToggleButtonWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()

```

`执行execute`

![ToggleButton](http://upload-images.jianshu.io/upload_images/1678789-1b9fb4787d396ec6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4.3、RadioButton**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class RadioButtonWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="RadioButton Demo")
        self.set_border_width(10)

        basic_box = Gtk.Box(spacing=6)
        self.add(basic_box)

        button1 = Gtk.RadioButton.new_with_label_from_widget(None, "Python")
        button1.connect("toggled", self.click_handler, "1")
        basic_box.pack_start(button1, False, False, 0)

        button2 = Gtk.RadioButton.new_with_label_from_widget(button1, "PHP")
        button2.connect("toggled", self.click_handler, "2")
        basic_box.pack_start(button2, False, False, 0)

        button3 = Gtk.RadioButton.new_with_label_from_widget(button1, "Swift")
        button3.connect("toggled", self.click_handler, "3")
        basic_box.pack_start(button3, False, False, 0)

    @staticmethod
    def click_handler(button, name):
        if button.get_active():
            state = "on"
        else:
            state = "off"
        print("Button", name, "was turned", state)


win = RadioButtonWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![RadioButton](http://upload-images.jianshu.io/upload_images/1678789-f1d73c32507af6ee.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4.4、LinkButton**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

app = Gtk.Window()
app.set_border_width(10)
button = Gtk.LinkButton("https://samego.com", "SameGo")
app.add(button)

app.connect("delete-event", Gtk.main_quit)
app.show_all()
Gtk.main()
```

`执行execute`

![LinkButton](http://upload-images.jianshu.io/upload_images/1678789-8b21cb7c0d79cf69.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4-5、SpinButton**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class SpinButtonWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="SpinButton")
        self.set_border_width(10)

        hbox = Gtk.Box(spacing=6)
        self.add(hbox)
        # 范围 参数 | 默认值 最小值 最大值 自增值  ? ?
        adjustment = Gtk.Adjustment(1, 0, 10, 1, 10, 0)
        self.spinbutton = Gtk.SpinButton()
        self.spinbutton.set_adjustment(adjustment)
        hbox.pack_start(self.spinbutton, False, False, 0)

        check_numeric = Gtk.CheckButton("数字")
        check_numeric.connect("toggled", self.on_numeric_toggled)
        hbox.pack_start(check_numeric, False, False, 0)

        check_ifvalid = Gtk.CheckButton("If Valid")
        check_ifvalid.connect("toggled", self.on_ifvalid_toggled)
        hbox.pack_start(check_ifvalid, False, False, 0)

    def on_numeric_toggled(self, button):
        self.spinbutton.set_numeric(button.get_active())

    def on_ifvalid_toggled(self, button):
        if button.get_active():
            policy = Gtk.SpinButtonUpdatePolicy.IF_VALID
        else:
            policy = Gtk.SpinButtonUpdatePolicy.ALWAYS
        self.spinbutton.set_update_policy(policy)


win = SpinButtonWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![SpinButton](http://upload-images.jianshu.io/upload_images/1678789-48f2502b5fe24f42.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4-6、**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

app = Gtk.Window()

# 定义switch
switch = Gtk.Switch()
switch.set_active(True)
app.add(switch)

app.connect("delete-event", Gtk.main_quit)
app.show_all()
Gtk.main()
```

`执行execute`

![SwitchButton](http://upload-images.jianshu.io/upload_images/1678789-d2781ca96f970b0a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)



___

**4-7、ProgressBar**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi
from gi.overrides import GObject

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class ProgressBarWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="ProgressBar Demo")
        self.set_border_width(10)

        # 定义一个容器
        basic_box = Gtk.Box(orientation=Gtk.Orientation.VERTICAL, spacing=6)
        self.add(basic_box)

        # 定义进度条
        self.progressbar = Gtk.ProgressBar()
        basic_box.pack_start(self.progressbar, True, True, 0)

        button = Gtk.CheckButton("显示文字")
        button.connect("toggled", self.on_show_text_toggled)
        basic_box.pack_start(button, True, True, 0)

        button = Gtk.CheckButton("激活模式")
        button.connect("toggled", self.on_activity_mode_toggled)
        basic_box.pack_start(button, True, True, 0)

        button = Gtk.CheckButton("从左向右")
        button.connect("toggled", self.on_right_to_left_toggled)
        basic_box.pack_start(button, True, True, 0)

        self.timeout_id = GObject.timeout_add(50, self.on_timeout, None)
        self.activity_mode = False

    def on_show_text_toggled(self, button):
        show_text = button.get_active()
        if show_text:
            text = "进度条的显示文本"
        else:
            text = None
        self.progressbar.set_text(text)
        self.progressbar.set_show_text(show_text)

    def on_activity_mode_toggled(self, button):
        self.activity_mode = button.get_active()
        if self.activity_mode:
            self.progressbar.pulse()
        else:
            self.progressbar.set_fraction(0.0)

    def on_right_to_left_toggled(self, button):
        value = button.get_active()
        self.progressbar.set_inverted(value)

    def on_timeout(self, user_data):
        """
        Update value on the progress bar
        """
        if self.activity_mode:
            self.progressbar.pulse()
        else:
            new_value = self.progressbar.get_fraction() + 0.01
            if new_value > 1:
                new_value = 0
            self.progressbar.set_fraction(new_value)

        # As this is a timeout function, return True so that it
        # continues to get called
        return True

win = ProgressBarWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()

```

`执行execute`

![ProgressBar](http://upload-images.jianshu.io/upload_images/1678789-bd92cffc0d0d7689.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**4.8、Spinner**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class SpinnerAnimation(Gtk.Window):
    def __init__(self):

        Gtk.Window.__init__(self, title="Spinner")
        self.set_border_width(3)
        self.connect("delete-event", Gtk.main_quit)

        self.button = Gtk.ToggleButton("开始Spinning")
        self.button.connect("toggled", self.on_button_toggled)
        self.button.set_active(False)

        self.spinner = Gtk.Spinner()

        self.table = Gtk.Table(3, 2, True)
        self.table.attach(self.button, 0, 2, 0, 1)
        self.table.attach(self.spinner, 0, 2, 2, 3)

        self.add(self.table)
        self.show_all()

    def on_button_toggled(self, button):
        if button.get_active():
            self.spinner.start()
            self.button.set_label("停止Spinning")
        else:
            self.spinner.stop()
            self.button.set_label("开始Spinning")


spinner = SpinnerAnimation()
spinner.show_all()
Gtk.main()
```

`执行execute`

![Spinner](http://upload-images.jianshu.io/upload_images/1678789-431e5ee79e209a2b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-1、CellRendererText**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

class CellRendererTextWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererTextWindow")
        self.set_default_size(400, 300)

        self.list_store = Gtk.ListStore(str, str)

        # 添加数据
        self.list_store.append(["PHP", "世界上最好的语言"])
        self.list_store.append(["Alic", "一个大学的大叔"])
        self.list_store.append(["Python", "感觉时日不多了"])

        # 定义tree_view
        tree_view = Gtk.TreeView(model=self.list_store)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("主题", renderer_text, text=0)
        tree_view.append_column(column_text)

        renderer_editable_text = Gtk.CellRendererText()
        # 设置可编辑属性
        renderer_editable_text.set_property("editable", True)

        column_editable_text = Gtk.TreeViewColumn("编辑试试",renderer_editable_text, text=1)
        tree_view.append_column(column_editable_text)

        renderer_editable_text.connect("edited", self.text_edited_handler)

        self.add(tree_view)

    def text_edited_handler(self, widget, index, text):
        self.list_store[index][1] = text

win = CellRendererTextWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![CellRendererText](http://upload-images.jianshu.io/upload_images/1678789-c5dcebede221f6e1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-2、CellRendererToggle**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk

class CellRendererToggleWindow(Gtk.Window):

    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererToggle")
        self.set_default_size(200, 200)

        # 定义数据
        self.list_store = Gtk.ListStore(str, bool, bool)
        self.list_store.append(["Debian", False, True])
        self.list_store.append(["OpenSuse", True, False])
        self.list_store.append(["Fedora", False, False])

        # 定义树视图
        tree_view = Gtk.TreeView(model=self.list_store)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("系统", renderer_text, text=0)
        tree_view.append_column(column_text)

        renderer_toggle = Gtk.CellRendererToggle()
        renderer_toggle.connect("toggled", self.on_cell_toggled)

        column_toggle = Gtk.TreeViewColumn("喜欢", renderer_toggle, active=1)
        tree_view.append_column(column_toggle)

        renderer_radio = Gtk.CellRendererToggle()
        renderer_radio.set_radio(True)
        renderer_radio.connect("toggled", self.on_cell_radio_toggled)

        column_radio = Gtk.TreeViewColumn("最爱", renderer_radio, active=2)
        tree_view.append_column(column_radio)

        self.add(tree_view)

    def on_cell_toggled(self, widget, index):
        self.list_store[index][1] = not self.list_store[index][1]

    def on_cell_radio_toggled(self, widget, index):
        selected_path = Gtk.TreePath(index)
        for row in self.list_store:
            row[2] = (row.path == selected_path)

win = CellRendererToggleWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![CellRendererToggle](http://upload-images.jianshu.io/upload_images/1678789-2b53d9242a0ecade.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-3、CellRendererPixbuf**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class CellRendererPixbufWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererPixbuf")
        self.set_default_size(400, 300)

        self.list_store = Gtk.ListStore(str, str)
        self.list_store.append(["新建", "document-new"])
        self.list_store.append(["打开", "document-open"])
        self.list_store.append(["保存", "document-save"])

        tree_view = Gtk.TreeView(model=self.list_store)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("动作", renderer_text, text=0)
        tree_view.append_column(column_text)

        renderer_pixbuf = Gtk.CellRendererPixbuf()
        column_pixbuf = Gtk.TreeViewColumn("图标", renderer_pixbuf, icon_name=1)
        tree_view.append_column(column_pixbuf)

        self.add(tree_view)

app = CellRendererPixbufWindow()
app.connect("delete-event", Gtk.main_quit)
app.show_all()
Gtk.main()
```

`执行execute`

![CellRendererPixbufWindow](http://upload-images.jianshu.io/upload_images/1678789-a6a189e943ba8f64.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-4、CellRendererCombo**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class CellRendererComboWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererCombo Example")
        self.set_default_size(200, 200)

        # 数据源
        list_store = Gtk.ListStore(str)
        list_store.append(["PHP"])
        list_store.append(["Python"])
        list_store.append(["Swift"])
        list_store.append(["Shell"])

        self.list_store_default = Gtk.ListStore(str, str)
        self.list_store_default.append(["最好的语言", "PHP"])
        self.list_store_default.append(["时间不多了", "Python"])
        self.list_store_default.append(["全美推广", "Swift"])

        tree_view = Gtk.TreeView(model=self.list_store_default)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("编程留言", renderer_text, text=0)
        tree_view.append_column(column_text)

        renderer_combo = Gtk.CellRendererCombo()
        renderer_combo.set_property("editable", True)
        renderer_combo.set_property("model", list_store)
        renderer_combo.set_property("text-column", 0)
        renderer_combo.set_property("has-entry", False)
        renderer_combo.connect("edited", self.on_combo_changed)

        column_combo = Gtk.TreeViewColumn("Combo", renderer_combo, text=1)
        tree_view.append_column(column_combo)

        self.add(tree_view)

    def on_combo_changed(self, widget, path, text):
        self.list_store_default[path][1] = text


win = CellRendererComboWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![CellRendererCombo](http://upload-images.jianshu.io/upload_images/1678789-6a02d8a577a63ff1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-5、CellRendererProgress**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi
from gi.overrides import GObject

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class CellRendererProgressWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererProgress")

        self.set_default_size(200, 200)

        self.liststore = Gtk.ListStore(str, int, bool)
        self.current_iter = self.liststore.append(["PHP", 0, False])
        self.liststore.append(["MySQL", 0, False])
        self.liststore.append(["Apache", 0, False])

        treeview = Gtk.TreeView(model=self.liststore)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("环境", renderer_text, text=0)
        treeview.append_column(column_text)

        renderer_progress = Gtk.CellRendererProgress()
        column_progress = Gtk.TreeViewColumn("安装进度", renderer_progress,
                                             value=1, inverted=2)
        treeview.append_column(column_progress)

        self.add(treeview)

        self.timeout_id = GObject.timeout_add(100, self.on_timeout, None)

    def on_inverted_toggled(self, widget, path):
        self.liststore[path][2] = not self.liststore[path][2]

    def on_timeout(self, user_data):
        new_value = self.liststore[self.current_iter][1] + 1
        if new_value > 100:
            self.current_iter = self.liststore.iter_next(self.current_iter)
            if self.current_iter == None:
                self.reset_model()
            new_value = self.liststore[self.current_iter][1] + 1

        self.liststore[self.current_iter][1] = new_value
        return True

    def reset_model(self):
        for row in self.liststore:
            row[1] = 0
        self.current_iter = self.liststore.get_iter_first()


win = CellRendererProgressWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![CellRendererProgress](http://upload-images.jianshu.io/upload_images/1678789-f6d34847ed747713.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

**5-6、CellRendererSpin**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class CellRendererSpinWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="CellRendererSpin Example")

        self.set_default_size(200, 200)

        self.liststore = Gtk.ListStore(str, int)
        self.liststore.append(["Oranges", 5])
        self.liststore.append(["Apples", 4])
        self.liststore.append(["Bananas", 2])

        treeview = Gtk.TreeView(model=self.liststore)

        renderer_text = Gtk.CellRendererText()
        column_text = Gtk.TreeViewColumn("Fruit", renderer_text, text=0)
        treeview.append_column(column_text)

        renderer_spin = Gtk.CellRendererSpin()
        renderer_spin.connect("edited", self.on_amount_edited)
        renderer_spin.set_property("editable", True)

        adjustment = Gtk.Adjustment(0, 0, 100, 1, 10, 0)
        renderer_spin.set_property("adjustment", adjustment)

        column_spin = Gtk.TreeViewColumn("Amount", renderer_spin, text=1)
        treeview.append_column(column_spin)

        self.add(treeview)

    def on_amount_edited(self, widget, path, value):
        self.liststore[path][1] = int(value)


win = CellRendererSpinWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![CellRendererSpin](http://upload-images.jianshu.io/upload_images/1678789-07cf067865f1719e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**5-7、ComboBox **

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class ComboBoxWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="ComboBox Example")

        self.set_border_width(10)

        name_store = Gtk.ListStore(int, str)
        name_store.append([1, "张三"])
        name_store.append([2, "李四"])
        name_store.append([3, "王五"])
        name_store.append([4, "赵六"])
        name_store.append([5, "孙七"])
        name_store.append([6, "周八"])

        basic_box = Gtk.Box(orientation=Gtk.Orientation.VERTICAL, spacing=6)

        name_combo = Gtk.ComboBox.new_with_model_and_entry(name_store)
        name_combo.connect("changed", self.on_name_combo_changed)
        name_combo.set_entry_text_column(1)
        basic_box.pack_start(name_combo, False, False, 0)

        language_store = Gtk.ListStore(str)
        languages = ["PHP", "Swift", "Shell", "Python", "Java",
                     "HTML", "Object-C", "Go"]
        for country in languages:
            language_store.append([country])

        language_combo = Gtk.ComboBox.new_with_model(language_store)
        language_combo.connect("changed", self.on_country_combo_changed)
        renderer_text = Gtk.CellRendererText()
        language_combo.pack_start(renderer_text, True)
        language_combo.add_attribute(renderer_text, "text", 0)
        basic_box.pack_start(language_combo, False, False, True)

        currency_combo = Gtk.ComboBoxText()
        currency_combo.set_entry_text_column(0)
        currency_combo.connect("changed", self.on_currency_combo_changed)
        for currency in languages:
            currency_combo.append_text(currency)

        basic_box.pack_start(currency_combo, False, False, 0)

        self.add(basic_box)

    @staticmethod
    def on_name_combo_changed(combo):
        tree_iter = combo.get_active_iter()
        if tree_iter is not None:
            model = combo.get_model()
            row_id, name = model[tree_iter][:2]
            print("Selected: ID=%d, name=%s" % (row_id, name))
        else:
            entry = combo.get_child()
            print("Entered: %s" % entry.get_text())

    @staticmethod
    def on_country_combo_changed(combo):
        tree_iter = combo.get_active_iter()
        if tree_iter is not None:
            model = combo.get_model()
            country = model[tree_iter][0]
            print("Selected: country=%s" % country)

    @staticmethod
    def on_currency_combo_changed(combo):
        text = combo.get_active_text()
        if text is not None:
            print("Selected: currency=%s" % text)


win = ComboBoxWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-c99e6191c54ef3c4.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**6、IconView**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk
from gi.repository.GdkPixbuf import Pixbuf

icons = ["document-save", "edit-paste", "edit-copy"]


class IconViewWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self)
        self.set_default_size(200, 200)

        liststore = Gtk.ListStore(Pixbuf, str)
        iconview = Gtk.IconView.new()
        iconview.set_model(liststore)
        iconview.set_pixbuf_column(0)
        iconview.set_text_column(1)

        for icon in icons:
            pixbuf = Gtk.IconTheme.get_default().load_icon(icon, 64, 0)
            liststore.append([pixbuf, icon])

        self.add(iconview)


win = IconViewWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![IconView](http://upload-images.jianshu.io/upload_images/1678789-e2de6f8fb3501877.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**7、TextView**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class TextViewWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self)
        self.set_border_width(10)
        self.set_default_size(300, 200)

        text_view = Gtk.TextView()
        text_view.get_buffer().set_text("请输入内容...")
        self.add(text_view)


app = TextViewWindow()
app.connect("delete-event", Gtk.main_quit)
app.show_all()
Gtk.main()
```

`执行`

![TextView](http://upload-images.jianshu.io/upload_images/1678789-db84e4cb8ca665f5.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**8-1、Dialog**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class DialogExample(Gtk.Dialog):
    def __init__(self, parent):
        Gtk.Dialog.__init__(self, "My Dialog", parent, 0,
                            (Gtk.STOCK_CANCEL, Gtk.ResponseType.CANCEL,
                             Gtk.STOCK_OK, Gtk.ResponseType.OK))

        self.set_default_size(150, 100)
        self.set_border_width(10)

        label = Gtk.Label("你想干嘛")

        box = self.get_content_area()
        box.add(label)
        self.show_all()


class DialogWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Dialog Example")

        self.set_border_width(6)

        button = Gtk.Button("打开一个弹框")
        button.connect("clicked", self.on_button_clicked)

        self.add(button)

    def on_button_clicked(self, widget):
        dialog = DialogExample(self)
        response = dialog.run()

        if response == Gtk.ResponseType.OK:
            print("The OK button was clicked")
        elif response == Gtk.ResponseType.CANCEL:
            print("The Cancel button was clicked")

        dialog.destroy()


win = DialogWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Dialog](http://upload-images.jianshu.io/upload_images/1678789-5976729d835e96af.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**8-2、FileChooser**

`源码code`

```
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class FileChooserWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="文件目录选择弹框")

        box = Gtk.Box(spacing=6)
        self.add(box)

        button1 = Gtk.Button("选择文件")
        button1.connect("clicked", self.on_file_clicked)
        box.add(button1)

        button2 = Gtk.Button("选择目录")
        button2.connect("clicked", self.on_folder_clicked)
        box.add(button2)

    def on_file_clicked(self, widget):
        dialog = Gtk.FileChooserDialog("Please choose a file", self,
                                       Gtk.FileChooserAction.OPEN,
                                       (Gtk.STOCK_CANCEL, Gtk.ResponseType.CANCEL,
                                        Gtk.STOCK_OPEN, Gtk.ResponseType.OK))

        self.add_filters(dialog)

        response = dialog.run()
        if response == Gtk.ResponseType.OK:
            print("Open clicked")
            print("File selected: " + dialog.get_filename())
        elif response == Gtk.ResponseType.CANCEL:
            print("Cancel clicked")

        dialog.destroy()

    @staticmethod
    def add_filters(dialog):
        filter_text = Gtk.FileFilter()
        filter_text.set_name("Text files")
        filter_text.add_mime_type("text/plain")
        dialog.add_filter(filter_text)

        filter_py = Gtk.FileFilter()
        filter_py.set_name("Python files")
        filter_py.add_mime_type("text/x-python")
        dialog.add_filter(filter_py)

        filter_any = Gtk.FileFilter()
        filter_any.set_name("Any files")
        filter_any.add_pattern("*")
        dialog.add_filter(filter_any)

    def on_folder_clicked(self, widget):
        dialog = Gtk.FileChooserDialog("Please choose a folder", self,
                                       Gtk.FileChooserAction.SELECT_FOLDER,
                                       (Gtk.STOCK_CANCEL, Gtk.ResponseType.CANCEL,
                                        "Select", Gtk.ResponseType.OK))
        dialog.set_default_size(800, 400)

        response = dialog.run()
        if response == Gtk.ResponseType.OK:
            print("Select clicked")
            print("Folder selected: " + dialog.get_filename())
        elif response == Gtk.ResponseType.CANCEL:
            print("Cancel clicked")

        dialog.destroy()


win = FileChooserWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-5d0ef440a3205472.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

___

**9、Clipboard**

`源码code`

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
import gi

gi.require_version('Gtk', '3.0')
from gi.repository import Gtk


class ClipboardWindow(Gtk.Window):
    def __init__(self):
        Gtk.Window.__init__(self, title="Clipboard")

        table = Gtk.Table(3, 2)

        from gi.overrides import Gdk
        self.clipboard = Gtk.Clipboard.get(Gdk.SELECTION_CLIPBOARD)
        self.entry = Gtk.Entry()
        self.image = Gtk.Image.new_from_icon_name("process-stop", Gtk.IconSize.MENU)

        button_copy_text = Gtk.Button("复制文本")
        button_paste_text = Gtk.Button("粘贴文本")
        button_copy_image = Gtk.Button("复制图片")
        button_paste_image = Gtk.Button("粘贴图片")

        table.attach(self.entry, 0, 1, 0, 1)
        table.attach(self.image, 0, 1, 1, 2)
        table.attach(button_copy_text, 1, 2, 0, 1)
        table.attach(button_paste_text, 2, 3, 0, 1)
        table.attach(button_copy_image, 1, 2, 1, 2)
        table.attach(button_paste_image, 2, 3, 1, 2)

        button_copy_text.connect("clicked", self.copy_text)
        button_paste_text.connect("clicked", self.paste_text)
        button_copy_image.connect("clicked", self.copy_image)
        button_paste_image.connect("clicked", self.paste_image)

        self.add(table)

    def copy_text(self, widget):
        self.clipboard.set_text(self.entry.get_text(), -1)

    def paste_text(self, widget):
        text = self.clipboard.wait_for_text()
        if text is not None:
            self.entry.set_text(text)
        else:
            print("No text on the clipboard.")

    def copy_image(self, widget):
        if self.image.get_storage_type() == Gtk.ImageType.PIXBUF:
            self.clipboard.set_image(self.image.get_pixbuf())
        else:
            print("No image has been pasted yet.")

    def paste_image(self, widget):
        image = self.clipboard.wait_for_image()
        if image is not None:
            self.image.set_from_pixbuf(image)


win = ClipboardWindow()
win.connect("delete-event", Gtk.main_quit)
win.show_all()
Gtk.main()
```

`执行execute`

![Clipboard](http://upload-images.jianshu.io/upload_images/1678789-acb51e9af4b679ad.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
[GTK3-API](http://python-gtk-3-tutorial.readthedocs.io/en/latest/menus.html)
___
Alic say : **[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
