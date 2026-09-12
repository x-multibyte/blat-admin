<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use XMultibyte\BlatAdmin\Models\Admin;

class AdminGuard extends SessionGuard
{
    /**
     * Get the currently authenticated user.
     */
    public function user(): ?Authenticatable
    {
        if ($this->loggedOut) {
            return null;
        }

        $user = parent::user();

        if ($user === null) {
            return null;
        }

        if (! $user instanceof Admin || ! $user->isActive()) {
            $this->user = null;
            $this->loggedOut = true;
            $this->session->remove($this->getName());

            return null;
        }

        return $user;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function attempt(array $credentials = [], mixed $remember = false): bool
    {
        $credentials['is_active'] = true;

        return parent::attempt($credentials, (bool) $remember);
    }

    /**
     * Log a user into the application.
     */
    public function login(Authenticatable $user, mixed $remember = false): void
    {
        if ($user instanceof Admin && ! $user->isActive()) {
            return;
        }

        parent::login($user, (bool) $remember);
    }
}
