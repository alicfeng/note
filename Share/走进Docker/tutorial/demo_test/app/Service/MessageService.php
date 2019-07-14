<?php
/**
 * Created by AlicFeng at 2019-06-09 18:49
 */

namespace App\Service;


use App\Enum\CodeEnum;


class MessageService extends BaseService
{
    public function message()
    {
        $data = [
            'name' => 'AlicFeng',
            'age'  => 24,
            'id'   => [
                'type'   => 1,
                'number' => '4417011888888888'
            ]
        ];
        return $this->result(CodeEnum::SUCCESS, $data);
    }

}
