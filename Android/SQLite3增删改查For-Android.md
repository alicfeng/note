前言：SQLite，是一款轻型的数据库，怎么轻法呢，那就只有一个数据库文件，不仅仅如此，并且它占用资源非常的低，只需要几百K的内存就够了。它能够支持Windows/Linux/Unix等等主流的操作系统，同时能够跟很多程序语言相结合，比如 Tcl、C#、PHP、Java等，还有ODBC接口，同样比起Mysql、PostgreSQL这两款开源的世界著名数据库管理系统讲，它的处理速度比他们都快。 至今，迎来的版本 SQLite 3已经发布。
___


**了解SQLiteOpenHelper**
~~~
package com.same.androidclass.model;

import android.content.Context;
import android.database.DatabaseErrorHandler;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import com.same.androidclass.config.AppConfig;
/**
 * 数据库助手
 * Created by alic on 16-5-5.
 */
public class DataBaseHelper extends SQLiteOpenHelper {
    public DataBaseHelper(Context context, String name, SQLiteDatabase.CursorFactory factory, int version) {
        super(context, name, factory, version);
    }

    public DataBaseHelper(Context context, String name, SQLiteDatabase.CursorFactory factory, int version, DatabaseErrorHandler errorHandler) {
        super(context, name, factory, version, errorHandler);
    }

    /**
     * 数据库第一次创建时被调用
     *
     * @param db 数据库
     */
    @Override
    public void onCreate(SQLiteDatabase db) {
        //创建学生实体数据表
//        private String studentId;//学号
//        private String username;//姓名
//        private String gradeYear;//年级
//        private String profession;//专业
//        private String idCard;//身份证
//        private String email;//邮箱
//        private String gradeAdmin;//行政班
//        private String assistant;//辅导员
//        private String headTeacher;//班主任
        db.execSQL("CREATE TABLE "+ AppConfig.TABLE_STUDENT+"(" +
                        "id INTEGER PRIMARY KEY AUTOINCREMENT," +
                        "studentId VARCHAR(11)," +
                        "username VARCHAR(6)," +
                        "gradeYear VARCHAR(4)," +
                        "profession VARCHAR(20)," +
                        "idCard VARCHAR(18)," +
                        "email VARCHAR(20)," +
                        "gradeAdmin VARCHAR(25)," +
                        "assistant VARCHAR(6)," +
                        "headTeacher VARCHAR(6)" +
                        ")"
        );
    }

    /**
     * 软件版本号发生改变时调用
     *
     * @param db         数据库
     * @param oldVersion 旧版本
     * @param newVersion 新版本
     */
    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        System.out.println("应用版本已经修改了");
    }
}

~~~
___



**SQLite3 For Insert增**
~~~
//数据库助手
DataBaseHelper dataBaseHelper = new DataBaseHelper(context, AppConfig.DATABASE_NAME,null,1);
//数据库 写
SQLiteDatabase writableDatabase = dataBaseHelper.getWritableDatabase();
//生成ContentValues对象，key:列名  value:想插入的值
ContentValues values = new ContentValues();
values.put("studentId", student.getStudentId());
values.put("username", student.getUsername());
values.put("gradeYear", student.getGradeYear());
values.put("profession", student.getProfession());
values.put("idCard", student.getIdCard());
values.put("email", student.getEmail());
values.put("gradeAdmin", student.getGradeAdmin());
values.put("assistant", student.getAssistant());
values.put("headTeacher", student.getHeadTeacher());
//参数1：表名  
//参数2：如果你想插入空值，那么你必须指定它的所在的列  
//参数3：ContentValues对象
writableDatabase.insert(AppConfig.TABLE_STUDENT, null,values);
System.out.println("写进一条数据--用户信息");
~~~
___


**SQLite3 For Delete删**
~~~
//数据库助手
DataBaseHelper dataBaseHelper = new DataBaseHelper(context, AppConfig.DATABASE_NAME,null,1);
//数据库 读
SQLiteDatabase readableDatabase = dataBaseHelper.getReadableDatabase();
//参数1：表名  
//参数2：where子句  
//参数3：where子句对应的条件值 
writableDatabase.delete(AppConfig.TABLE_STUDENT, "studentId=?", new String[]{student.getStudentId()});
System.out.println("删除了一条数据--用户信息");
~~~
___


**SQLite3 For Update改**
~~~
//数据库助手
DataBaseHelper dataBaseHelper = new DataBaseHelper(context, AppConfig.DATABASE_NAME,null,1);
//数据库 读
SQLiteDatabase readableDatabase = dataBaseHelper.getReadableDatabase();
//生成ContentValues对象，key:列名  value:想插入的值
ContentValues values = new ContentValues();
values.put("username", student.getUsername());
values.put("gradeYear", student.getGradeYear());
values.put("profession", student.getProfession());
values.put("idCard", student.getIdCard());
values.put("email", student.getEmail());
values.put("gradeAdmin", student.getGradeAdmin());
values.put("assistant", student.getAssistant());
values.put("headTeacher", student.getHeadTeacher());
//参数1：表名
//参数2：ContentValues对象
//参数3：where子句
//参数4：where子句对应的条件值
writableDatabase.update(AppConfig.TABLE_STUDENT, values, "studentId=?", new String[]{student.getStudentId()});
System.out.println("更新了一条数据--用户信息");
~~~
___



**SQLite3 For Query查**
~~~
//数据库助手
DataBaseHelper dataBaseHelper = new DataBaseHelper(context, AppConfig.DATABASE_NAME,null,1);
//数据库 读
SQLiteDatabase readableDatabase = dataBaseHelper.getReadableDatabase();‘
//参数1：表名
//参数2：要想显示的列
//参数3：where子句
//参数4：where子句对应的条件值
//参数5：分组方式
//参数6：having条件
//参数7：排序方式
Cursor cursor = readableDatabase.query(AppConfig.TABLE_STUDENT, null, "studentId=?", new String[]{student.getStudentId()}, null, null, null, null);
//遍历
//cursor.getCount()；结果集的数量
while(cursor.moveToNext()){
cursor.getString(cursor.getColumnIndex("username"));
}  
~~~
___

**SQLite3可视化工具**
图形界面（一）`sqlitebrowser程式（qt3）`
~~~
sudo apt-get install sqlitebrowser
~~~
启动图形界面可以在终端提示符后输入sqlitebrowser

图形界面（二）`sqliteman`
~~~
sudo apt-get install sqliteman
~~~

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-f3ca930c91ab37aa.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
