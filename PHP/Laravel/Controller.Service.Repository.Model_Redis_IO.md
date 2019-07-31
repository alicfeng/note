#### Controller | 控制器层

```php
class MessageController extends BaseController
{
    private $_messageService;

    public function __construct(MessageService $messageService)
    {
        $this->_messageService = $messageService;
    }

    public function message(Request $request)
    {
        // 所需要的参数皆在从控制层获取处理
        $user_id    = auth()->id;
        $message_id = $request->get('message_id');

        return $this->_messageService->message($user_id, $message_id);
    }
}
```



#### Service | 业务层

```php
class MessageService extends BaseService
{
    private $_messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        parent::__construct();
        $this->_messageRepository = $messageRepository;
    }

    public function message(int $user_id, int $message_id)
    {
        $message = $this->_messageRepository->message($user_id, $message_id);

        // 所有业务相关的皆在此业务层处理
        if (!$message) {
            return $this->rspHelper->result(CodeEnum::DATA_NOT_EXIST);
        }

        return $this->rspHelper->result(CodeEnum::SUCCESS, $message);
    }
}
```



#### Repository | 资源层 ( 文件、数据库、缓存、流等 )

```php
class MessageRepository
{
    public function message(int $user_id, int $message_id)
    {
        // 所有资源层处理的皆在资源层处理 比如文件、数据库、缓存、流等
        $message = Cache::rememberForever('message', function () use ($user_id, $message_id) {
            return Message::query()->where(['user_id' => $user_id, 'id' => $message_id])->get();
        });

        return $message;
    }
}
```



#### Model | 模型

```php
class Message extends BaseModel
{
    protected $table = 'message';
}
```



#### Result

```
➜ curl -s "https://dev.samego.com/api/message?message_id=1" | jq .
{
  "code": 1000,
  "message": "success",
  "data": [{
    "name": "alicfeng"
  },{
    "name": "feng"
  }]
}
```



> 对于API接口使用了 此包 [Laravel-helper](https://packagist.org/packages/alicfeng/laravel-helper)