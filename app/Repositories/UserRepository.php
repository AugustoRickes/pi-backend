<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function getUserById(int $id)
    {
        return User::find($id);
    }

    public function getUserItemCount(int $id)
    {
        return \DB::table('lista')->where('user_id', $id)->count();
    }
}