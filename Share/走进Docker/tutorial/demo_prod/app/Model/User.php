<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class, 'uid', 'id')->select(['userinfo.phone']);
        // 第一个参数为关联的模型名字，第二个参数为外键，第三个参数为主键
    }
}
