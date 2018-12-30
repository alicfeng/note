**需求逻辑：**
`H5 code `
```html
<input type='file' id="file">
```
我想判断`input`文件对象的文件是否为空，惨了！  官方没有提供这个事件，JQ也没有，input的其他类型还是可以的。怎么办呢？
这样，我判断是否改变了就可以，不过这也是缓解的一步
> 适合刚上传文件的判断，并且是一改变就立马执行动作的。

```javascript
$("#file").change(function(){
    console.log("haha...")
});
```
