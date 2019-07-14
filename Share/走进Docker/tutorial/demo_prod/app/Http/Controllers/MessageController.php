<?php
/**
 * Created by AlicFeng at 2019-06-09 18:49
 */

namespace App\Http\Controllers;


use App\Http\Requests\StoreBlogPost;
use App\Service\MessageService;

class MessageController extends BaseController
{
    private $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    public function message()
    {
        return $this->service->message();
    }
}
