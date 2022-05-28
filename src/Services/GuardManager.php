<?php

declare(strict_types=1);

namespace Xgbnl\Bearer\Services;

use Xgbnl\Bearer\Exception\BearerException;
use Xgbnl\Bearer\Traits\CreateUserProviders;
use Illuminate\Contracts\Foundation\Application;
use Xgbnl\Bearer\BearerGuard;
use Xgbnl\Bearer\Contracts\Factory\Factory;
use Xgbnl\Bearer\Contracts\Guard\GuardContact;
use Closure;

final class GuardManager implements Factory
{
    use CreateUserProviders;

    protected Application $app;

    protected array $customCreators = [];
    protected array $guards         = [];

    protected Closure $userResolver;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->userResolver = fn($guard = null) => $this->guard($guard)->user();
    }

    public function guard(?string $name = null): GuardContact
    {
        $name = $name ?? $this->getDefaultDriver();

        return $this->guards[$name] ?? $this->guards[$name] = $this->resolve($name);
    }

    public function shouldUse(string $name): void
    {
        $name = $name ?? $this->getDefaultDriver();

        $this->setDefaultDriver($name);

        $this->userResolver = fn($guard = null) => $this->guard($guard)->user();
    }

    /**
     * @throws BearerException
     */
    protected function resolve(string $name): GuardContact
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new BearerException("守卫角色[{$name}] 没有定义");
        }

        return $this->createBearerDriver($config);
    }

    public function createBearerDriver(array $config): GuardContact
    {
        $guard = new BearerGuard(
            $this->createUserProvider($this->app, $config['provider']),
            $this->app['request'],
            $config['input_key'] ?? 'bearer_token',
            $config['storage_key'] ?? 'bearer_token',
            $config['hash'] ?? false,
            $config['expire'] ?? 60,
        );

        $this->app->refresh('request', $guard, 'setRequest');

        return $guard;
    }

    protected function getConfig(string $name): ?array
    {
        return $this->app['config']["bearer.roles.{$name}"];
    }

    protected function getDefaultDriver(): string
    {
        return $this->app['config']['bearer.defaults.role'];
    }

    protected function setDefaultDriver(string $name): void
    {
        $this->app['config']['bearer.defaults.role'] = $name;
    }

    /**
     * 获取用户解析闭包
     * @return Closure|null
     */
    public function userResolver(): ?Closure
    {
        return $this->userResolver;
    }

    /**
     * 设置闭包引用到用户解析变量
     * @param Closure $userResolver
     * @return $this
     */
    public function resolveUsersUsing(Closure $userResolver): self
    {
        $this->userResolver = $userResolver;

        return $this;
    }
}
