<?php

declare(strict_types=1);

use Xgbnl\Bearer\Contracts\Factory\Factory as FactoryContract;
use Xgbnl\Bearer\Contracts\Guard\GuardContact;
use Xgbnl\Bearer\Exception\BearerException;

if (!function_exists('guard')) {
    /**
     * Return new a role guard instance.
     * @param string|null $role
     * @return GuardContact
     */
    function guard(string $role = null): GuardContact
    {
        if (is_null($role)) {
            return app(FactoryContract::class)->guard();
        }

        return app(FactoryContract::class)->guard($role);
    }
}
