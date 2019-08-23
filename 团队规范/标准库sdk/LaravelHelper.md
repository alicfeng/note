##  Laravel-helper

####  Install

######  install by composer.json

```json
{
    "require": {
        "alicfeng/laravel-helper": "^1.1.1"
    }
}
```

######  install by cli

```shell
composer require alicfeng/laravel-helper:v1.1.1 -vvv
```



####  Configurate

######  Configure ServiceProvider

```php
'providers' => [
   AlicFeng\Helper\ServiceProvider\HelperServiceProvider::class,
]
```

######  Execute command on terminal

```php
php artisan vendor:publish --provider="AlicFeng\Helper\ServiceProvider\HelperServiceProvider"
```

######  Configuration file

> `config/helper.php`

```php
<?php
return [
    // about package setting
    'package' => [
        /*Response Package Structure*/
        'structure' => [
            'code'    => 'code',
            'message' => 'message',
            'data'    => 'data',
        ],

        /*Package encrypt Setting*/
        'crypt'     => [
            'instance' => \AlicFeng\Helper\Crypt\HelperCryptService::class,
            'method'   => 'aes-128-ecb',
            'password' => '1234qwer',
        ],

        /*Package format*/
        'format'    => 'json',

        /*Log*/
        'log'       => [
            'log'   => true,
            'level' => 'notice'
        ],
    ],

    //  about log setting
    'log'     => [
        'extra_field' => [
            'runtime_file'   => true,
            'memory_message' => false,
            'web_message'    => false,
            'process_id'     => false,
        ],
    ],

    // debug model setting
    'debug'   => false,
];
```



## Helper Model

#### ResponseHelper

###### What function does it have?

- Generate Unified Structure Package Following RESTful
- Response Package Encrypt By Middleware

###### Usage

- Generate Unified Structure Package Following RESTful

  > For example about `Controller - Service`
  >
  > using `return $this->result($codeEnum, $result);` 

  Developers only care about the results of service processing, while the response structure is built by components.

  ```php
  ## HelloController
  class HelloController extends Controller
  {
      private $helloService;
      public function __construct(HelloService $helloService)
      {
          $this->helloService = $helloService;
      }
      public function package()
      {
        	$name = request('name','');
          return $this->helloService->package($name);
      }
  }
  
  ## BaseHelloService
  class BaseHelloService {
      /**
       * @var ResponseHelper
       */
      protected $rspHelper;
  
      public function __construct()
      {
          $this->rspHelper = app(ResponseHelper::class);
      }
  }
  
  ## HelloService 
  class HelloService extends BaseHelloService {
      public function __construct()
    {
          parent::__construct();
    }
      public function package(string $name = '')
      {
          $codeEnum = [1000, 'success']; // this should define in app/Enum/CodeEnum.php
          $result   = [
              'name'   => $name,
              'age'    => 24,
          ];
          return $this->rspHelper->result($codeEnum, $result);
      }
  }
  ```
  
  Request Result
  
  ```shell
  ➜ curl -s "https://dev.samego.com/api/package?name=alicfeng" | jq .
  {
    "code": 1000,
    "message": "success",
    "data": {
      "name": "alicfeng",
      "age": 24
    }
  }
  ```



- Response Package Encrypt By Middleware

  > First register middle in Kernel 
  >
  > Then add middleware in route file or __construct

  `app/Http/Kernel.php`

  ```php
  protected $routeMiddleware = [
    'package.encrypt'=>\AlicFeng\Helper\Middleware\EncryptMiddleware::class
  ];
  ```

  `routes/api.php`

  ```php
  Route::middleware('package.encrypt')->get('/package', 'HelloController@package');
  ```

  Request Result

  ```shell
  ➜  demo curl -s "http://127.0.0.1:8181/api/package?name=alicfeng"       
  1aGGUAPDs0x80Qqnacwv1LQOd5crQrJZRJ6-7AbmrYb2EqvhUZ4flXBe6DKbKGGYbboU--qwz64epLapZc9nxSCsn4XIW-QG8taK-g_bteE
  ```

  Component provides the function of decrypting ciphertext through Web !!! see~

  now open you browser input `{$host/helper/decrypt}` then enter.

  ![decrypt-web](https://raw.githubusercontent.com/alicfeng/laravel-helper/master/doc/web@2x.png)

  > You can specify instances of encryption and decryption by configuring them，
>
  > `config/helper.php` in `package.crypt.instance`
  >
  > have to implements `HelperCryptServiceInterface`
  
   

#### LogHelper

###### display log content format

```ini
[2019-08-20 23:36:37.310839] local.INFO: push cash {"user_id":9510,"cash":"52.00"}
{"memory_usage":"14 MB","memory_peak_usage":"14 MB","runtime_file":{"file":"/Users/alicfeng/tutorial/github/tmp/demo/app/Console/Commands/AlicFeng.php:69","function":"App\\Console\\Commands\\AlicFeng->handle"}}

[2019-08-20 23:36:37.311712] local.DEBUG: source data come from cache 
{"memory_usage":"14 MB","memory_peak_usage":"14 MB","runtime_file":{"file":"/Users/alicfeng/tutorial/github/tmp/demo/app/Console/Commands/AlicFeng.php:71","function":"App\\Console\\Commands\\AlicFeng->handle"}}

[2019-08-20 23:36:37.311834] local.NOTICE: sync article successful {"user_id":9510}
{"memory_usage":"14 MB","memory_peak_usage":"14 MB","runtime_file":{"file":"/Users/alicfeng/tutorial/github/tmp/demo/app/Console/Commands/AlicFeng.php:73","function":"App\\Console\\Commands\\AlicFeng->handle"}}

[2019-08-20 23:36:37.311935] local.WARNING: logout failed {"user_id":8888}
{"memory_usage":"14 MB","memory_peak_usage":"14 MB","runtime_file":{"file":"/Users/alicfeng/tutorial/github/tmp/demo/app/Console/Commands/AlicFeng.php:75","function":"App\\Console\\Commands\\AlicFeng->handle"}}
```

###### configure

> `config/logging.php`

```php
'daily' => [
  'driver'         => 'daily',
  'path'           => storage_path('logs/laravel.log'),
  'level'          => 'debug',
  'permission'     => 0777,
  'tap'            => [\AlicFeng\Helper\Component\Log\LogEnhancer::class],
  'days'           => 7,
  'formatter'      => \Monolog\Formatter\LineFormatter::class,
  'formatter_with' => [
    'dateFormat'                 => 'Y-m-d H:i:s.u',
    'allowInlineLineBreaks'      => true,
    'ignoreEmptyContextAndExtra' => true,
    'format' => "[%datetime%] %channel%.%level_name%: %message% %context%\n%extra%\n"
  ]
]
```

###### Usage

```php
Log::info('push cash', ['user_id' => 9510, 'cash' => '52.00']);
Log::debug('source data come from cache');
Log::notice('sync article successful', ['user_id' => 9510]);
Log::warning('logout failed', ['user_id' => 8888]);
// or 
LogHelper::info('push cash', ['user_id' => 9510, 'cash' => '52.00']);
LogHelper::debug('source data come from cache');
LogHelper::notice('sync article successful', ['user_id' => 9510]);
LogHelper::warning('logout failed', ['user_id' => 8888]);
```



#### CurlHelper

> 完善中



#### DateTimeHelper

###### api function

- msectime

  ```php
  DateTimeHelper::msectime()
  ```

