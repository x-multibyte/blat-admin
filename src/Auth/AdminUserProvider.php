<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use SensitiveParameter;
use XMultibyte\BlatAdmin\Models\Admin;

class AdminUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     */
    public function retrieveById(mixed $identifier): ?Authenticatable
    {
        $model = $this->createModel();

        return $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     */
    public function retrieveByToken(mixed $identifier, #[SensitiveParameter] mixed $token): ?Authenticatable
    {
        $model = $this->createModel();

        $retrievedModel = $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where('is_active', true)
            ->first();

        if (! $retrievedModel) {
            return null;
        }

        $rememberToken = $retrievedModel->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, (string) $token)
            ? $retrievedModel
            : null;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $credentials['is_active'] = true;

        return parent::retrieveByCredentials($credentials);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if ($user instanceof Admin && ! $user->isActive()) {
            return false;
        }

        return parent::validateCredentials($user, $credentials);
    }
}
