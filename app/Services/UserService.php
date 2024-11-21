<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserDetails(int $id): array
    {
        $user = $this->userRepository->getUserById($id);
        $itemCount = $this->userRepository->getUserItemCount($id);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'item_count' => $itemCount,
            'totalkudos' => $user->kudos,
        ];
    }
}