<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="bookmark" type="image/x-icon" href="https://www.easyicon.net/download/ico/1121550/128/">
    <link rel="shortcut icon" href="https://www.easyicon.net/download/ico/1121550/128/">
    <meta name="keywords" content="laravel,samego,alicfeng,log,laravel-runtime">
    {{--jquery--}}
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    {{--semantic ui | javascript and css--}}
    <link href="https://cdn.bootcss.com/semantic-ui/2.4.0/semantic.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/semantic-ui/2.4.0/semantic.min.js"></script>
    {{--flatpickr | javascript and css--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Runtime Detail | Samego</title>
</head>
<body>
<div id="container">
    <div id="header">
        <!--left | search-->
        <div class="ui icon primary input">
            <input id="startDate" class="datepicker" value="" placeholder="Please choose startDate">
            <input id="endDate" class="datepicker" value="" placeholder="Please choose endDate">
            <button class="ui basic button" id="searchAction">
                <i class="icon teal search"></i>Search
            </button>
        </div>

        <!--right | Clear and Reload buttons-->
        <div class="ui teal right floated buttons">
            <button class="ui basic button" id="clearAction">
                <i class="icon teal trash alternate outline"></i>Clear
            </button>
            <button class="ui basic button" id="reloadAction">
                <i class="icon teal sync"></i>Reload
            </button>
        </div>
    </div>
    <div id="body">
        <table class="ui celled teal selectable striped table table-condensed">
            <thead>
            <tr class="center aligned">
                <th>path | 请求地址</th>
                <th>method | 请求方法</th>
                <th>count | 请求次数</th>
                <th>max(mx) | 最大耗时</th>
                <th>min(mx) | 最少耗时</th>
                <th>average(mx) | 平均耗时</th>
            </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>
<script>
  /**
   * Created by alic(AlicFeng) on 17-6-16 下午6:22 from PhpStorm.
   * Email is alic@samego.com
   */
  /*
   env        ： pure-JS
   dependent  ： semantic
   use        ： before -> include this JS-file ; after -> remove this dom what id eq sameLoading by JS
   */

  /*建立节点*/
  var loadingDiv = document.createElement("div");
  var invertedDiv = document.createElement("div");
  var textDiv = document.createElement("div");

  /*节点配置*/
  var loadingText = "Loading...";
  textDiv.innerText = loadingText;
  textDiv.setAttribute("class", "ui text loader");

  invertedDiv.appendChild(textDiv);
  invertedDiv.setAttribute("class", "ui active inverted dimmer");
  invertedDiv.appendChild(textDiv);

  loadingDiv.setAttribute("class", "ui segment");
  loadingDiv.setAttribute("id", "sameLoading");
  loadingDiv.style.height = "100%";
  loadingDiv.style.border = "none";
  loadingDiv.style.margin = "0";
  loadingDiv.style.padding = "0";
  loadingDiv.style.background = "#ffffff";
  loadingDiv.appendChild(invertedDiv);

  /*加载主节点*/
  document.body.style.overflow = "hidden";

  function loading() {
    document.body.appendChild(loadingDiv);
  }

  /**
   * 删除预加载 sameLoading
   */
  function removeLoading() {
    document.body.style.overflow = "auto";
    document.body.removeChild(loadingDiv);
  }
</script>
<script>
  $(document).ready(function () {
    var startDate = $("#startDate");
    var endDate = $("#endDate");
    var searchAction = $("#searchAction");
    var reloadAction = $("#reloadAction");
    var clearAction = $("#clearAction");
    var tbody = $("#tbody");
    const URI_LIST = '/runtime/list';
    const URI_CLEAR = '/runtime/clear';
    const URI_RELOAD = '/runtime/reload';

    initView();

    function query(startDate, endDate) {
      loading();
      $.ajax({
        type: "POST",
        url: URI_LIST,
        contentType: "application/json; charset=utf-8",
        data: {startDate: startDate, endDate: endDate},
        dataType: "json",
        success: function (data) {
          if ('0000' === data.code) {
            tbody.html('');
            $.each(data.data, function (index) {
              tbody.append("<tr><td>" + data.data[index]['path'] + "</td><td class='center aligned'>" + data.data[index]['method'] + "</td><td class='center aligned'>" + data.data[index]['count'] + "</td><td class='center aligned'>" + data.data[index]['max'] + "</td><td class='center aligned'>" + data.data[index]['min'] + "</td><td class='center aligned'>" + data.data[index]['average'] + "</td></tr>");
            });
            promptBox('successfully load', 1);
            return true;
          }
          promptBox(4, 'fail');
        },
        error: function (message) {
          console.log(message);
        }
      });
      removeLoading();
    }

    searchAction.click(function () {
      if (startDate.val() && endDate.val()) {
        query(startDate.val(), endDate.val())
      }
    });

    reloadAction.click(function () {
      $.getJSON(URI_RELOAD, {}, function (data) {
        if ('0000' === data.code) {
          query(startDate.val(), endDate.val());
        } else {
          promptBox('failed reload', 1);
        }
      });
    });

    clearAction.click(function () {
      $.getJSON(URI_CLEAR, {}, function (data) {
        if ('0000' === data.code) {
          tbody.html('');
          promptBox('successfully clear', 1);
        } else {
          promptBox('failed  clear', 1);
        }
      });
    });

    $(".datepicker").flatpickr();

    function initView() {
      query(startDate.val(), endDate.val())
    }

    function promptBox(message, type) {
      //获取屏幕的宽度
      var winWidth = window.innerWidth ? window.innerWidth : document.body.clientWidth;

      var types = ["success", "info", "warning", "error"];
      var icons = ["checkmark", "info ", "warning", "remove"];
      var body = document.body;
      var promptBox = document.createElement("div");
      var icon = document.createElement("i");
      var content = document.createTextNode(message);

      promptBox.className = "ui message " + types[type];
      promptBox.style.position = "fixed";
      promptBox.style.width = "auto";
      promptBox.style.minWidth = "200px";
      promptBox.style.fontWeight = "bold";

      promptBox.style.margin = "0 auto";
      icon.className = "icon " + icons[type];
      promptBox.appendChild(icon);
      promptBox.appendChild(content);
      body.appendChild(promptBox);
      undefined !== window.samegoPromp ? clearPromp() : null;
      window.samegoPromp = true;
      //解决居中的问题
      promptBox.style.right = (winWidth - promptBox.offsetWidth) / 2 + "px";
      promptBox.style.top = "0";

      setTimeout(clearPromp, 5000);

      function clearPromp() {
        var tempOpacity = 1;
        (function () {
          promptBox.style.filter ? promptBox.style.filter = 'alpha(opacity:' + tempOpacity * 100 + ')' : promptBox.style.opacity = tempOpacity;
          tempOpacity -= 0.05;
          try {
            tempOpacity > 0 ? setTimeout(arguments.callee, 100) : (promptBox ? body.removeChild(promptBox) : null) && delete window.samegoPromp;
          } catch (e) {

          }
        })();
      }
    }
  })
</script>
