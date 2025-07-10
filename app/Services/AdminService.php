<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Interfaces\GetVerifiedInterface;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    private $userRepository;
    private $getVerifiedRepository;

    public function __construct(
        UserInterface $userRepository,
        GetVerifiedInterface $getVerifiedRepository
    ) {
        $this->userRepository = $userRepository;
        $this->getVerifiedRepository = $getVerifiedRepository;
    }

    public function getUser($id)
    {
        return $this->userRepository->getUser($id);
    }

    public function getUsers()
    {
        return $this->userRepository->getUsers();
    }

    public function assignAdminToUser($user_id, $admin_id)
    {
        $this->userRepository->assignAdminToUser($user_id, $admin_id);
    }

    public function deleteRequestUsers()
    {
        return $this->userRepository->getDeleteRequestUsers();
    }

    public function deletedUsers()
    {
        return $this->userRepository->getDeletedUsers();
    }

    public function getVerificationHistory()
    {
        return $this->getVerifiedRepository->getVerificationHistory();
    }

    public function getPendingProvidersRequests()
    {
        return $this->getVerifiedRepository->getPendingProvidersRequests();
    }

    public function updateUserNotes($user_id, $note)
    {
        $this->userRepository->updateUserNotes($user_id, $note);
    }

    public function updateGetVerifiedNotes($verify_id, $note)
    {
        $this->getVerifiedRepository->updateGetVerifiedNotes($verify_id, $note);
    }

    public function deleteStorageImages($user)
    {
        if ($user->profile_picture != null && $user->profile_picture != '') {
            $profilePicture = '/storage/' . $user->profile_picture;
            Storage::delete($profilePicture);
        }
    }
}
