<?php

namespace Xgbnl\Bearer\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

interface StatefulGuard extends Guard
{
    /**
     * 将用户登录至应用程序
     *
     * Log a user into the application.
     *
     * @param Model|Authenticatable $user
     * @return array
     */
    public function login(Model|Authenticatable $user): array;

    /**
     * 确定 token 是否过期
     *
     * Determine if token expires in.
     * @return void
     */
    public function expires(): void;

    /**
     * 将用户从应用程序中注销
     *
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout(): void;
}
