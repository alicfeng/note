<?php
/**
 * Created by AlicFeng at 2019-06-29 01:22
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Service\MessageService;

class HelloController extends Controller
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
