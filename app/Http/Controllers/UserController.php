<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchUserEmailRequest;
use App\Http\Requests\PatchUserPasswordRequest;
use App\Http\Requests\PatchUserPhoneNumberRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        return new UserResource(auth()->user());
    }

    public function update(UpdateUserRequest $request)
    {
        return new UserResource(tap(Auth::user())->update($request->validated()));
    }

    public function patchPassword(PatchUserPasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        return ['data' => ['success' => true]];
    }

    public function patchEmail(PatchUserEmailRequest $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        return ['data' => ['success' => true]];
    }

    public function patchPhoneNumber(PatchUserPhoneNumberRequest $request)
    {
        $user = Auth::user();
        $user->phone_number = $request->phone_number;
        $user->phone_number_verified_at = null;
        $user->save();

        return ['data' => ['success' => true]];
    }
}
