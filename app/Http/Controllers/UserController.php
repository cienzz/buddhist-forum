<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPatchEmailRequest;
use App\Http\Requests\UserPatchPasswordRequest;
use App\Http\Requests\UserPatchPhoneNumberRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        return new UserResource(auth()->user());
    }

    public function update(UserUpdateRequest $request)
    {
        return new UserResource(tap(Auth::user())->update($request->validated()));
    }

    public function patchPassword(UserPatchPasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        return ['data' => ['success' => true]];
    }

    public function patchEmail(UserPatchEmailRequest $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        return ['data' => ['success' => true]];
    }

    public function patchPhoneNumber(UserPatchPhoneNumberRequest $request)
    {
        $user = Auth::user();
        $user->phone_number = $request->phone_number;
        $user->phone_number_verified_at = null;
        $user->save();

        return ['data' => ['success' => true]];
    }
}
