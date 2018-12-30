前言：昨晚在做课程设计的结构遇到了二级Fragment(在Fragment里面嵌入了ViewPager)，在数据显示的时候，如果使用简单的PagerAdapter的话，代码在这个适配器里面会造成庞大的不好效果，不仅仅如此，使用mvp模式，Presenter就会跑到adapter里面，虽然adapter属于view图层，但是不利于数据的处理。然而我找到了一个比较推荐的方法：ViewPager使用FragmentPagerAdapter适配器。FragmentPagerAdapter派生自PagerAdapter，它是用来呈现Fragment页面的。
___
**适配器实现 - FragmentPagerAdapter**
~~~

/**
 * Home页面的适配器adapter
 * Created by alic on 16-4-30.
 */
public class HomeFragmentAdapter extends FragmentPagerAdapter{
    private List<Fragment> fragmentList = new ArrayList<>();
    
    //构造方法一 推荐
    public HomeFragmentAdapter(FragmentManager fm) {
        super(fm);

        this.fragmentList.add(new HomeClassesFragment());
        this.fragmentList.add(new HomeAttendanceFragment());
        this.fragmentList.add(new HomeExamFragment());
        this.fragmentList.add(new HomeGradeFragment());
    }

    //构造方法二
    public HomeFragmentAdapter(FragmentManager fm, List<Fragment> fragmentList) {
        super(fm);
        this.fragmentList = fragmentList;
    }
    
    @Override
    public Fragment getItem(int position) {
        return fragmentList.get(position);
    }

    @Override
    public int getCount() {
        return fragmentList.size();
    }
}
~~~
___


**UI布局实现 - Fragment**
~~~
/**
 *考试Fragment
 * Created by alic on 16-5-8.
 */
public class HomeExamFragment extends Fragment {
    private View viewCourse;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        viewCourse = inflater.inflate(R.layout.home_viewpager_three,container, false);
        return viewCourse;
    }
}
~~~
___


**Activity实现之二级Fragment**
~~~
//实例化viewPager
ViewPager viewPager = (ViewPager) parentView.findViewById(R.id.home_main_viewPager);
HomeFragmentAdapter adapter = new HomeFragmentAdapter(getChildFragmentManager());
viewPager.setAdapter(adapter);
~~~
___

**Activity实现之简单的activity**
~~~
//实例化viewPager
ViewPager viewPager = (ViewPager) parentView.findViewById(R.id.home_main_viewPager);
HomeFragmentAdapter adapter = new HomeFragmentAdapter(getSupportFragmentManager());
viewPager.setAdapter(adapter);
~~~
上面的俩个Activity实现的区别就是前者在Fragment实现，后者在Activity实现
本质上就是FragmentManager获取的方法不一样前者是通过getChildFragmentManager()获取，
后者是通过getSupportFragmentManager()获取。
___
**注意的问题**
问题1
当在this.fragmentList.add(new HomeClassesFragment())可能会造成无法添加
原因
由于编译器智能自动导包问题造成的，两个类导入的Fragment包不一致
解决
将两个Fragment包都导入为ndroid.support.v4.app.Fragment即可



































