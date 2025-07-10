<?php

namespace App\Services;

use App\Interfaces\UserInterface;

use Illuminate\Support\Str;

class UserService
{
    private $userRepository;

    public function __construct(
        UserInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function getUser($id)
    {
        return $this->userRepository->getUser($id);
    }

    public function updateUserPassword($user_id, $password)
    {
        return $this->userRepository->updateUserPassword($user_id, $password);
    }

    public function updateBlockStatus($userId, $setStatus)
    {
        return $this->userRepository->updateBlockStatus($userId, $setStatus);
    }

    public function softDelete($userId, $adminId)
    {
        return $this->userRepository->softDelete($userId, $adminId);
    }

    public function hardDelete($userId)
    {
        $random = Str::random(10);
        $timestamp = round(microtime(true)*1000);
        return $this->userRepository->hardDelete($userId, $random, $timestamp);
    }

    public function updateOTPDetails($user)
    {
        $this->userRepository->updateOTPDetails($user);
    }

    public function updateDeleteRequest($userId)
    {
        $this->userRepository->updateDeleteRequest($userId);
    }
}
