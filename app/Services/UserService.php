<?php 


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserService
{

    public function createUser(array $data): User
    {
      return User::createUser($data);
    }

    public function loginUser(array $credentials)
    {
      if(!auth()->attempt($credentials)) {
        throw new \Exception('メールアドレスかパスワードが誤っています');
      }
      return auth()->user();
    }

    public function getUserById($userId): User
    {
      $user = User::find($userId);
      if(!$user) {
        throw new ModelNotFoundException('ユーザーが見つかりません');
      }
      return $user;
    }

    public function updateUser($userId, array $data): User
    {
      $user = $this->getUserById($userId);
      $user->update($data);
      return $user;
    }

    public function updateUserPassword($userId, $currentPassword, $newPassword)
    {
      $user = $this->getUserById($userId);

      if(!Hash::check($currentPassword, $user->password)) {
        throw new \Exception('現在のパスワードが誤っています');
      }

      $user->password = Hash::make($newPassword);
      $user->save();
      return $user;
    }

    public function deleteUser($userId)
    {
      $user = $this->getUserById($userId);
      $user->delete();
      return $user;
    }
}