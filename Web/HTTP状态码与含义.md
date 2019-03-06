**[HTTP STATUS CODES](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes)**

- **1xx | 临时响应**

  | 状态码 |          含义          |                 说明                 |
  | :----: | :--------------------: | :----------------------------------: |
  |  100   |      ` Continue`       |        客户端应当继续发送请求        |
  |  101   | ` Switching Protocols` |          通知客户端切换协议          |
  |  102   |     ` Processing`      |            表示正在处理中            |
  |  103   |     ` Early Hint`      | 提前告知客户端需要预加载外部资源文件 |

  

- **2xx | 成功**

  | 状态码 |               含义               |                             说明                             |
  | :----: | :------------------------------: | :----------------------------------------------------------: |
  |  200   |               `Ok`               |                             成功                             |
  |  201   |            ` Created`            |               请求成功并且服务器创建了新的资源               |
  |  202   |           ` Accepted`            |                       服务器已接受请求                       |
  |  203   | ` Non-Authoritative Information` |                  返回的信息可能来自另一来源                  |
  |  204   |          ` No Content`           |                 服务端成功处理还没有任何返回                 |
  |  205   |         ` Reset Content`         |                           重置内容                           |
  |  206   |        ` Partial Content`        |                服务器成功处理了部分`GET`请求                 |
  |  207   |         ` Multi-Status`          | 由WebDAV(RFC 2518)扩展的状态码，代表之后的消息体将是一个XML消息，并且可能依照之前子请求数量的不同，包含一系列独立的响应代码 |
  |  208   |       ` Already Reported`        |                           已经播报                           |
  |  226   |            ` IM Used`            |                           异步使用                           |

  

- **3xx | 重定向**

  | 状态码 |         含义         |                             说明                             |
  | :----: | :------------------: | :----------------------------------------------------------: |
  |  300   |  `Multiple Choices`  | 被请求的资源有一系列可供选择的回馈信息，每个都有自己特定的地址和浏览器驱动的商议信息 |
  |  301   | `Moved Permanently`  |                被请求的资源已永久移动到新位置                |
  |  302   |       `Found`        |           请求的资源现在临时从不同的 URI 响应请求            |
  |  303   |     `See Other`      | 对应当前请求的响应可以在另一个 URI 上被找到，而且客户端应当采用 GET 的方式访问那个资源 |
  |  304   |    `Not Modified`    |                            未修改                            |
  |  305   |     `Use Proxy`      |                           使用代理                           |
  |  306   |    `Switch Proxy`    |                 开关代理，新规范已经废除此项                 |
  |  307   | `Temporary Redirect` |                          临时重定向                          |
  |  308   | `Permanent Redirect` |                          永久重定向                          |
  |        |                      |                                                              |
  |        |                      |                                                              |

  

- **4xx | 客户端请求错误**

  | 状态码 |                            含义                             |                             说明                             |
  | :----: | :---------------------------------------------------------: | :----------------------------------------------------------: |
  |  400   |                        `Bad Request`                        |                           无效请求                           |
  |  401   |                       ` Unauthorized`                       |                 请求要求身份验证，未授权请求                 |
  |  402   |                     ` Payment Required`                     |             该状态码是为了将来可能的需求而预留的             |
  |  403   |                        ` Forbidden`                         |                          请求被禁止                          |
  |  404   |                        ` Not Found`                         |                        请求对象不存在                        |
  |  405   |                    ` Method Not Allowed`                    |                          方法不允许                          |
  |  406   |                      ` Not Acceptable`                      |              服务器已经理解请求，但是不允许执行              |
  |  407   |               `Proxy Authentication Required`               |                       需要代理身份验证                       |
  |  408   |                     ` Request Timeout`                      |                           请求超时                           |
  |  409   |                         ` Conflict`                         |              被请求的资源的当前状态之间存在冲突              |
  |  410   |                           `Gone`                            |                           请求丢失                           |
  |  411   |                      `Length Required`                      |    服务器拒绝在没有定义 Content-Length 头的情况下接受请求    |
  |  412   |                    `Precondition Failed`                    | 服务器在验证在请求的头字段中给出先决条件时，没能满足其中的一个或多个 |
  |  413   |                     `Payload Too Large`                     |                       请求在提数据过大                       |
  |  414   |                       `URI Too Long`                        |                          `url`太长                           |
  |  415   |                  `Unsupported Media Type`                   |                        媒体类型不支持                        |
  |  416   |                   `Range Not Satisfiable`                   | 请求中包含了`Range`请求头， 并且 Range 中指定的任何数据范围都与当前资源的可用范围不重合 |
  |  417   |                    ` Expectation Failed`                    |                           预期失败                           |
  |  418   |                       ` I'm a teapot`                       | 本操作码是在1998年作为IETF的传统愚人节笑话, 在RFC 2324 超文本咖啡壶控制协议中定义的，并不需要在真实的HTTP服务器中定义 |
  |  421   |                   ` Misdirected Request`                    |                           误导请求                           |
  |  422   |                   ` Unprocessable Entity`                   |                        无法处理的实体                        |
  |  423   |                          ` Locked`                          |             当前资源被锁定。（RFC 4918 WebDAV）              |
  |  424   |                    ` Failed Dependency`                     | 由于之前的某个请求发生的错误，导致当前请求失败，例如 PROPPATCH。（RFC 4918 WebDAV） |
  |  425   | `Reserved for WebDAV advanced collections expired proposal` |           保留用于WebDAV高级集合过期提案   RFC2817           |
  |  426   |                     ` Upgrade Required`                     |             客户端应当切换到TLS/1.0（RFC 2817）              |
  |  428   |                  ` Precondition Required`                   |                    要求先决条件  RFC6585                     |
  |  429   |                     `Too Many Requests`                     |                          太多的请求                          |
  |  431   |             ` Request Header Fields Too Large`              |                        请求头字段太大                        |
  |  451   |              ` Unavailable For Legal Reasons`               |                 因法律原因无法获得  RFC7725                  |
  |  499   |               ` Client has closed connection`               |                      客户端主动关闭连接                      |

  



- **5xx | 服务端处理失败**

  | 状态码 |                含义                |          说明          |
  | :----: | :--------------------------------: | :--------------------: |
  |  500   |      ` Internal Server Error`      |     内部服务器错误     |
  |  501   |         ` Not Implemented`         |         未实现         |
  |  502   |          `  Bad Gateway`           |        无效网关        |
  |  503   |       ` Service Unavailable`       |       服务不可用       |
  |  504   |         ` Gateway Timeout`         |        网关超时        |
  |  505   |    `HTTP Version Not Supported`    |    http 版本不支持     |
  |  506   |     ` Variant Also Negotiates`     | 服务器存在内部配置错误 |
  |  507   |      ` Insufficient Storage`       |   远程服务器返回错误   |
  |  508   |          ` Loop Detected`          |       检测到循环       |
  |  510   |          ` Not Extended`           |         不延长         |
  |  511   | ` Network Authentication Required` |    网络需要身份验证    |

  



