ProgressBar样式
~~~
<?xml version="1.0" encoding="utf-8"?>
<rotate xmlns:android="http://schemas.android.com/apk/res/android"
    android:fromDegrees="0"
    android:pivotX="50%"
    android:pivotY="50%"
    android:toDegrees="360">
    <shape
        android:innerRadiusRatio="3"
        android:shape="ring"
        android:thicknessRatio="8"
        android:useLevel="false">
        <gradient
            android:centerColor="@color/colorPrimary"
            android:centerY="0.50"
            android:endColor="@android:color/white"
            android:startColor="@color/colorPrimary"
            android:type="sweep"
            android:useLevel="false"/>
    </shape>
</rotate>
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-35c8085952486447.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
~~~
<?xml version="1.0" encoding="utf-8"?>
<rotate xmlns:android="http://schemas.android.com/apk/res/android"
    android:drawable="@color/colorPrimary"
    android:fromDegrees="0"
    android:pivotX="50%"
    android:pivotY="50%"
    android:toDegrees="360" >
</rotate>
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-1d0725856649f941.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
~~~
<?xml version="1.0" encoding="utf-8"?>
<layer-list xmlns:android="http://schemas.android.com/apk/res/android">
    <item
        android:id="@android:id/background">
        <clip>
            <shape>
                <solid android:color="@android:color/white"/>
            </shape>
        </clip>
    </item>
    <item android:id="@android:id/progress">
        <clip>
            <shape>
                <solid android:color="@color/colorPrimary"/>
            </shape>
        </clip>
    </item>
</layer-list>  
~~~
![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-a270303edcfd71f4.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)













