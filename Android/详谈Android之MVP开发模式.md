**前言**
以前在写Web项目的时候，也许没有过多的考虑项目的开发模式，然而习惯了采用MVC的模式去开发项目，然而最近开发Android项目的时候，总是感觉View和Model联系很紧密，从逻辑上基本不能分离出来，然后就了解到了MVP模式，这种模式View层与Model层完全分离的,从而减轻了Activity的负担。
___
* MVP模式的简介
MVP开发模式是从经典的MVC模式演变过来的，其基本思路都是相通的。简单来说：MVP模式是基于MVC模式的。
**M是Model层，提供业务数据**
**V是View视图，显示数据**
**P是Presenter控制者，进行逻辑处理**
___
* MVP模式与MVC模式的区别


![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-d6e45798bba87a7f.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)从图中可以清晰地看出：它们有一个比较明显的区别就是，MVC中是允许Model和View进行交互的；而MVP中很明显，Model与View之间的交互由Presenter完成，并且Presenter与View之间的交互是通过接口的，换句话说：在MVP中View并不直接使用Model，它们之间的通信是通过Presenter来进行的，所有的交互都发生在Presenter内部。
___
* MVP模式的优缺点
优点:**降低耦合，代码灵，层级职责更明显，易于单元测试**
缺点:**造成类数量爆炸，代码复杂度和学习成本高，在某些场景下presenter的复用会产生接口冗余**
入门的体验：给一个demo你看的话，你会发现MVP模式开发的思路很清晰，但是你会发觉项目会产生很多的类，代码的复杂度会高些。网上常说：虽然mvp基于mvc，但是由于类太多未必可以写的出来。
___
* MVP的小实战DEMO
不想写太多理论性的文笔，接下来讲解demo的编程思路【代码展示-用户登陆】
**demo的项目结构**

![Paste_Image.png](http://upload-images.jianshu.io/upload_images/1678789-85cd121e6b7fb81c.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
___
**Bean** UserBean毋庸置疑这个必须有的，和mvc一样
~~~
package com.samego.alic.demomvp.bean;

/**
 * UserBean
 * Created by alic on 16-4-13.
 */
public class User {
    private String username;//用户名
    private String password;//密码

    //construct
    public User() {
    }

    public User(String username, String password) {
        this.username = username;
        this.password = password;
    }

    //set and get start
    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
    //set and get end
}

~~~
___
**Model** 从业务上思考，User至少有login()该方法
~~~
package com.samego.alic.demomvp.model;

import com.samego.alic.demomvp.presenter.OnLoginListener;

/**
 *UserModel接口
 * Created by alic on 16-4-13.
 */
public interface UserModel {
    /**
     * 用户登陆
     * @param username 用户名
     * @param password 密码
     * @param onLoginListener 登陆结果监听是否登陆成功
     */
    void login(String username,String password,OnLoginListener onLoginListener);
}
~~~
~~~
package com.samego.alic.demomvp.model;

/**
 *UserModelImpl类实现UserModel接口
 * Created by alic on 16-4-13.
 */
public class UserModelImpl implements UserModel {

    @Override
    public void login(final String username, final String password, final OnLoginListener loginListener) {
        new Thread(){
            @Override
            public void run() {
                try {
                    //模拟网络数据交互等待时间
                    Thread.sleep(2000);
                    //模拟登陆成功
                    if("alic".equals(username)&&"123456".equals(password)){
                        User user = new User(username,password);
                        loginListener.loginSuccess(user);
                        //模拟登陆失败
                    }else {
                        loginListener.loginFailed();
                    }
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }
        }.start();
    }
}
~~~
~~~
package com.samego.alic.demomvp.model;

/**
 *登陆监听接口
 * Created by alic on 16-4-13.
 */
public interface OnLoginListener {
    /**
     * 用户登陆成功
     * @param user UserBean
     */
    void loginSuccess(User user);

    /**
     * 用户登陆失败
     */
    void loginFailed();
}
~~~
**View** 难点就是在View这里，View该有哪些方法，因为Presenter与View交互是通过接口。
简单分析该接口应该有哪些方法,**其实这些方法就是辅助Presenter的逻辑而存在的**
~~~
//获取用户名 密码
String getUsername();
String getPassword();
~~~
~~~
//清空用户名 密码
void clearUsername();
void clearPassword();
~~~
~~~
//显示 隐藏加载
void showLoading();
void hideLoading();
~~~
~~~
//跳转主界面
void toMainActivity(User user);~~~
~~~
//显示错误
void showFailed();
~~~
Summary
~~~
package com.samego.alic.demomvp.view;

import com.samego.alic.demomvp.bean.User;

/**
 *用户登录辅助视图view 虽然由activity显示，目的就是辅助Presenter
 * Created by alic on 16-4-13.
 */
public interface UserLoginView {
    //获取用户名 密码
    String getUsername();
    String getPassword();

    //清空用户名 密码
    void clearUsername();
    void clearPassword();

    //显示 隐藏加载
    void showLoading();
    void hideLoading();

    //跳转主界面
    void toMainActivity(User user);

    //显示错误
    void showFailed();
}
~~~
~~~

package com.samego.alic.demomvp.view;

/**
 *用户登陆界面主视图view
 *Created by alic on 16-4-13.
 */
public class LoginActivity extends AppCompatActivity  implements UserLoginView, View.OnClickListener {
    private EditText username,password;
    private Button login,reset;
    private ProgressBar loginLoading;
    private UserLoginPresenter loginPresenter = new UserLoginPresenter(this);
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        StatusBarCompat.setStatusBarColor(this,StatusBarCompat.COLOR_ToolBar_HIGHTBLUE);
        //初始化
        initViews();
    }

    /**
     * 初始化视图组件
     */
    public void initViews(){
        username = (EditText) findViewById(R.id.login_username);
        password = (EditText) findViewById(R.id.login_password);
        login = (Button) findViewById(R.id.login_button);
        reset = (Button) findViewById(R.id.reset_button);
        loginLoading = (ProgressBar) findViewById(R.id.login_loading);
        loginLoading.setVisibility(View.INVISIBLE);

        login.setOnClickListener(this);
        reset.setOnClickListener(this);
    }

    @Override
    public String getUsername() {
        return username.getText().toString();
    }

    @Override
    public String getPassword() {
        return password.getText().toString();
    }

    @Override
    public void clearUsername() {
        username.setText("");
    }

    @Override
    public void clearPassword() {
        password.setText("");
    }

    @Override
    public void showLoading() {
        loginLoading.setVisibility(View.VISIBLE);
    }

    @Override
    public void hideLoading() {
        loginLoading.setVisibility(View.INVISIBLE);
    }

    @Override
    public void toMainActivity(User user) {
//        Intent intent = new Intent(LoginActivity.this,MainActivity.class);
//        startActivity(intent);
        Toast.makeText(this,"登陆成功",Toast.LENGTH_SHORT).show();

    }

    @Override
    public void showFailed() {
        Toast.makeText(this,"用户名或密码错误",Toast.LENGTH_SHORT).show();
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.login_button:
                loginPresenter.login();
                break;
            case R.id.reset_button:
                loginPresenter.clear();
                break;
            default:
                break;
        }
    }
}
~~~
**Presenter**  Presenter是用作Model和View之间交互的桥梁,该方法也应该有哪些方法呢，**这些方法其实就是我们在界面上所看到的逻辑处理**，比如login()以及reset()
~~~
package com.samego.alic.demomvp.presenter;

/**
 *UserLoginPresenter
 * Presenter负责完成UserLoginView层与UserModel层的交互
 * Created by alic on 16-4-13.
 */
public class UserLoginPresenter {
    private UserModel userModel;
    private UserLoginView userLoginView;
    private Handler handler = new Handler();

    //construct
    public UserLoginPresenter(UserLoginView userLoginView) {
        this.userLoginView = userLoginView;
        userModel = new UserModelImpl();
    }

    /**
     * 登陆function
     */
    public void login(){
        userLoginView.showLoading();
        userModel.login(userLoginView.getUsername(), userLoginView.getPassword(), new OnLoginListener() {
            @Override
            public void loginSuccess(final User user) {
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        userLoginView.toMainActivity(user);
                        userLoginView.hideLoading();
                    }
                });
            }

            @Override
            public void loginFailed() {
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        userLoginView.showFailed();
                        userLoginView.hideLoading();
                    }
                });
            }
        });
    }

    /**
     * 清空function
     */
    public void clear(){
        userLoginView.clearUsername();
        userLoginView.clearPassword();
    }
}

~~~

以上就是一个非常精简又经典的Demo，对于有些不了解的或者不对的地方欢迎交谈，THX！
