**前言：**
最近呢，接了一个PLC-ERP的项目，要使用RS232串口通信，时间很赶、实在没有办法了，就是用Java动身喽。好早学习Java的时候，仅仅封装了一个连接以及关闭数据库的类，这次呢，那肯定要抽象出操作的Event方法的。
___

**有了BasicDao之后，在简单的增删改查中，你会体验到特别方便！**
___

如何连接数据库就不说了(jdbc)，重点在于封装操作MySQL数据库的方法，还是直接看代码！
```Java
package com.samego.java.dev.dao.basic;

import com.samego.java.dev.common.BasicConnection;
import com.samego.java.dev.dao.presenter.SameGoToolDao;
import org.apache.commons.beanutils.BeanUtils;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

/**
 * BaseDao的实现
 * 所有的Dao都要继承该类
 * Created by alic(AlicFeng) on 17-5-24.
 * Email is alic@samego.com
 */
public class BasicDao {
    private Connection connection;
    private PreparedStatement preparedStatement;
    private ResultSet resultSet;

    /**
     * 更新的通用方法 including update/insert/delete
     *
     * @param sql         SQL
     * @param paramsValue prepareStatement sql语句中占位符对应的值（如果没有占位符，传入null）
     * @param logMessage  日志信息
     * @return 数据库更新的数目
     */
    public int update(String sql, Object[] paramsValue, String[] logMessage) {
        int result = -1;
        try {
            connection = BasicConnection.getConnection();
            preparedStatement = connection.prepareStatement(sql);
            int count = preparedStatement.getParameterMetaData().getParameterCount();
            if (paramsValue != null && paramsValue.length > 0) {
                //循环给参数赋值
                for (int i = 0; i < count; i++) {
                    preparedStatement.setObject(i + 1, paramsValue[i]);
                }
            }
            result = preparedStatement.executeUpdate();
        } catch (SQLException e) {
            this.writeLog(logMessage);
            e.printStackTrace();
        } finally {
            BasicConnection.closeConnection(null, preparedStatement, connection);
        }
        return result;
    }

    /**
     * 查询通用方法
     *
     * @param sql         SQL
     * @param paramsValue prepareStatement
     * @param tClass      对象的类
     * @param logMessage  日志
     * @param <T>         返回类的集合
     * @return 返回类的集合
     */
    public <T> List<T> query(String sql, Object[] paramsValue, Class<T> tClass, String[] logMessage) {
        List<T> list = new ArrayList<>();
        connection = BasicConnection.getConnection();
        try {
            preparedStatement = connection.prepareStatement(sql);
            if (paramsValue != null && paramsValue.length > 0) {
                for (int i = 0; i < paramsValue.length; i++) {
                    preparedStatement.setObject(i + 1, paramsValue[i]);
                }
            }
            resultSet = preparedStatement.executeQuery();
            ResultSetMetaData resultSetMetaData = resultSet.getMetaData();
            int columnCount = resultSetMetaData.getColumnCount();
            T t;
            while (resultSet.next()) {
                t = tClass.newInstance();
                for (int i = 0; i < columnCount; i++) {
                    String columnName = resultSetMetaData.getColumnName(i + 1);
                    Object value = resultSet.getObject(columnName);
                    BeanUtils.copyProperty(t, columnName, value);
                }
                list.add(t);
            }
        } catch (Exception e) {
            this.writeLog(logMessage);
            e.printStackTrace();
        } finally {
            BasicConnection.closeConnection(resultSet, preparedStatement, connection);
        }
        return list;
    }

    /**
     * @param sql         SQL
     * @param paramsValue prepareStatement
     * @param columnName  查询的字段名
     * @param logMessage  日志
     * @return 数量值
     */
    public Object queryByOne(String sql, Object[] paramsValue, String columnName, String[] logMessage) {
        Object result = null;
        connection = BasicConnection.getConnection();
        try {
            preparedStatement = connection.prepareStatement(sql);
            if (paramsValue != null && paramsValue.length > 0) {
                for (int i = 0; i < paramsValue.length; i++) {
                    preparedStatement.setObject(i + 1, paramsValue[i]);
                }
            }
            resultSet = preparedStatement.executeQuery();

            if (resultSet.next()) {
                result = resultSet.getObject(columnName);
            }
        } catch (Exception e) {
            this.writeLog(logMessage);
            e.printStackTrace();
        } finally {
            BasicConnection.closeConnection(resultSet, preparedStatement, connection);
        }
        return result;
    }

    /**
     * 写日志
     *
     * @param logMessage 日志信息
     */
    private void writeLog(String[] logMessage) {
        if (null != logMessage && 2 == logMessage.length) {
            SameGoToolDao.queryLog(logMessage[0], logMessage[1], false);
        }
    }
}
```
封装好了之后，那么我们就早Dao类继承，使用简洁又简单！看代码
- update

```Java
    @Override
    public boolean updateFinishPerProductTimeUnit(int time) {
        boolean result = false;
        String[] logMessage = {"更改系统值", "修改每一件产品的用时失败"};
        Object[] paramValues = {time};
        if (super.update(SQLCommands.UPDATE_PER_PRODUCT_TIME_UNIT, paramValues, logMessage) > 0) {
            result = true;
            ETCVar.PRODUCT_UNIT_TIME = time;
            SameGoToolDao.queryLog("更改系统值", "修改每一件产品的用时成功", true);
        }
        return result;
    }
```

- query

```Java
    @Override
    public ArrayList<MachineWork> machineWorkSign() {
        ArrayList<MachineWork> machineWorks = super.query(SQLCommands.MACHINE_WORK_SIGN_CHECK, null, MachineWork.class, null);
    }
```

- queryByOne

```java
    @Override
    public int getLastMonthFinishedOrderNum() {
        Object[] paramsValues = {Strings.ORDER_STATUS_LIST[2]};
        String[] logMessage = {"报告报表", "查询上个月的订单数失败"};
        int lastMonthOrderFinishedNum = Integer.parseInt(super.queryByOne(SQLCommands.LAST_MONTH_FINISHED_ORDER_NUM, paramsValues, "order_num", logMessage).toString());
        SameGoToolDao.queryLog("报告报表", "查询上个月的订单数成功", true);
        return lastMonthOrderFinishedNum;
    }
```

注意：
使用到的第三方Jar有
- org.apache.commons.beanutils.BeanUtils
- commons-logging-1.0.4.jar这个编辑代码看不出，但是一定要引入，上面的依赖这个
> 个人的建议：
1、对于SQL语句呢，最好集中在一个类文件
2、使用占位符赋值-PreparedStatement，防止SQL注入

___

**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
