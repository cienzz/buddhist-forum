<?php

namespace App\Http\Controllers;

use App\Enums\UserElement;
use App\Enums\UserShio;
use App\Enums\UserStatus;
use App\Enums\UserZodiac;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthTokenRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        return new UserResource(User::create($request->validated()));
    }

    public function token(AuthTokenRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = User::firstWhere('username', $request->username);

            if ($user->status == UserStatus::BLACKLIST) {
                throw new AuthorizationException(trans('auth.blacklist'));
            }

            $user->touch('login_at');
            $user->tokens()->where('name', $request->username)->forceDelete();

            return ['data' => ['token' => $user->createToken($request->username)->plainTextToken]];
        }

        throw new AuthorizationException(trans('auth.failed'));
    }

    public function logout()
    {
        $user = Auth::user();

        return [
            'data' => [
                'success' => $user->tokens()->where('name', $user->username)->forceDelete() ? true : false
            ]
        ];
    }
}
