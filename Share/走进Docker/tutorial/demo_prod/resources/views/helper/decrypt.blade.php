<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helper Decrypt | SameGo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="bookmark" type="image/x-icon" href="https://www.easyicon.net/download/ico/1121550/128/">
    <link rel="shortcut icon" href="https://www.easyicon.net/download/ico/1121550/128/">
    <meta name="keywords" content="laravel,samego,alicfeng,log,laravel-helper">
    {{--jquery--}}
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    {{--semantic ui | javascript and css--}}
    <link href="https://cdn.bootcss.com/semantic-ui/2.4.0/semantic.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/semantic-ui/2.4.0/semantic.min.js"></script>
    {{--clipboard js--}}
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    {{--pretty-json js css--}}
    <script src="https://cdn.bootcss.com/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdn.bootcss.com/backbone.js/1.4.0/backbone-min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/helper/pretty-json.css"/>
    <script src="/js/helper/pretty-json-min.js"></script>
</head>
<body>
<div id="container" style="margin: 10px 20px">
    <div id="header">
    </div>
    <div id="body">
        <div class="ui form">
            <div class="field">
                <label for="decryptContent">Please input decrypt content</label>
                <textarea id="decryptContent" rows="10" placeholder="Please input decrypt content"></textarea>
            </div>
            <div class="field">
                <label for="message">Package Message:
                    <button id="copy" class="copy" data-clipboard-text="[]">
                        Copy
                    </button>
                </label>
                <div id="message"></div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>
<script>
  $(document).ready(function () {
    let copy = document.getElementById("copy");
    let message = document.getElementById("message");
    let decryptContent = document.getElementById("decryptContent");
    let clipboard = new ClipboardJS('.copy');

    let API = '/helper/decrypt';

    initView();

    decryptContent.addEventListener('input', function () {
      query(decryptContent.value);
    });
    // 兼容IE
    decryptContent.addEventListener('propertychange', function () {//兼容IE
      query(decryptContent.value);
    });

    function query(content) {
      localStorage.setItem('decrypt', content);
      message.value = 'decrypting';
      $.post(API, {content: content}, function (data) {
        console.log(data.data);
        if (1000 === data.code) {
          copy.setAttribute('data-clipboard-text', JSON.stringify(data.data));
          let tree = new PrettyJSON.view.Node({
            el: message,
            data: data.data,
            dateFormat: "DD/MM/YYYY - HH24:MI:SS"
          });
          tree.expandAll();
        } else {
          copy.setAttribute('data-clipboard-text', '[]');
          message.innerText = 'error'
        }
      }, 'JSON');
    }

    function initView() {
      clipboard.on('success', function (e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        e.clearSelection();
        copy.innerHTML = 'copy success~';
        setTimeout(function () {
          copy.innerHTML = 'copy';
        }, 2000);
      });
      let cache = localStorage.getItem('decrypt');
      if (cache) {
        decryptContent.value = cache;
        query(cache);
      }
    }
  });
</script>
