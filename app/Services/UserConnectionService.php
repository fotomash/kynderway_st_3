<?php

namespace App\Services;

use App\Interfaces\UserConnectionsInterface;

class UserConnectionService
{
    private $userConnectionRepository;

    public function __construct(UserConnectionsInterface $userConnectionRepository)
    {
        $this->userConnectionRepository = $userConnectionRepository;
    }

    public function deleteJobUserId($user)
    {
        return $this->userConnectionRepository->deleteJobUserId($user->id);
    }

    public function deleteProviderId($user)
    {
        return $this->userConnectionRepository->deleteProviderId($user->id);
    }
}
