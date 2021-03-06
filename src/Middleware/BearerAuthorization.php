<?php

declare(strict_types=1);

namespace Xgbnl\Bearer\Middleware;

class BearerAuthorization extends Authorization
{
    public function doHandle()
    {
        if ($this->guard()->guest()) {
            trigger(403, '未验证,请登录后重试');
        }

        if ($this->guard()->expires()) {
            trigger(403, '令牌已过期,请重新登录');
        }
    }
}
