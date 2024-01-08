<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function signup(CreateUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json($user, 201);
    }

    public function signin(LoginRequest $request)
    {
        $user = $this->userService->loginUser($request->validated());
        return response()->json($user, 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'ログアウトしました。'], 200);
    }

    public function updateUser(UpdateUserRequest $request)
    {
      $user = $this->userService->updateUser(Auth::id(), $request->validated());
      return response()->json($user, 200);
    }

    public function updatePassword(updatePasswordRequest $request)
    {
      $currentPassword = $request->input('password');
      $newPassword = $request->input('newPassword');

      $user = $this->userService->updateUserPassword(Auth::id(), $currentPassword, $newPassword);
      return response()->json(['message'=> 'パスワードが更新されました。'], 200);
    }

    public function deleteUser()
    {
      $this->userService->deleteUser(Auth::id());
      return response()->json(['message'=> 'ユーザーが削除されました。'], 200);
    }

}