前言：课程设计已经基本完成，但是在点击切换Fragment的时候总是感觉有点卡顿，第一次读取网络服务器数据就体现的特别明显，在本地的话也会稍微有一点卡顿，因为我引用了一个多Fragment的框架，强迫症的我看着就是不舒服，查看框架源码...,果然，框架犯了一个低级的错误：切换Fragment竟然都是用replace()方法来替换Fragment。
___
**切换Fragment的方法简介**
`replace()`
该方法只是在上一个Fragment不再需要时采用的简便方法
`show() hide()  add()`
正确的切换方式是add()，切换时hide()，add()另一个Fragment；再次切换时，只需hide()当前，show()另一个
___
**看源码吧**
~~~
//错误的做法
//每次切换的时候，Fragment都会重新实例化，重新加载一边数据，这样非常消耗性能和用户的数据流量
public void switchFragment(Fragment targetFragment) {
    if (targetFragment == null)
      return;
    FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
    //目标Fragment替换原来的Fragment
    transaction.replace(R.id.content, targetFragment);
    transaction.commit();
  }
~~~
___
~~~
//正确的做法
private void switchFragment(Fragment targetFragment) {
    FragmentTransaction transaction = getSupportFragmentManager()
            .beginTransaction();
    if (!targetFragment.isAdded()) {
        transaction
                .hide(currentFragment)
                .add(R.id.main_fragment, targetFragment)
                .commit();
        System.out.println("还没添加呢");
    } else {
        transaction
                .hide(currentFragment)
                .show(targetFragment)
                .commit();
        System.out.println("添加了( ⊙o⊙ )哇");
    }
    currentFragment = targetFragment;
}
~~~
___
**[价值源于技术，贡献源于分享](https://github.com/alicfeng)**
