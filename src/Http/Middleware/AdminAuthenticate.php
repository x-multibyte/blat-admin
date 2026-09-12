<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse|JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response|RedirectResponse|JsonResponse
    {
        /** @var string $guard */
        $guard = Config::get('blat-admin.guard', 'blat-admin');

        if (Auth::guard($guard)->check()) {
            /** @var Response|RedirectResponse|JsonResponse $response */
            $response = $next($request);

            return $response;
        }

        if ($request->expectsJson()) {
            return new JsonResponse(['message' => 'Unauthenticated.'], 401);
        }

        return new RedirectResponse(route('blat-admin.login'));
    }
}
