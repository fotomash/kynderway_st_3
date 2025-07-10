<?php

namespace App\Services;

use App\Interfaces\GetVerifiedInterface;

class GetVerifiedService
{
    private $getVerifiedRepository;

    public function __construct(GetVerifiedInterface $getVerifiedRepository)
    {
        $this->getVerifiedRepository = $getVerifiedRepository;
    }

    public function get($id)
    {
        return $this->getVerifiedRepository->get($id);
    }

    public function assignAdmin($id, $admin_id)
    {
        return $this->getVerifiedRepository->assignAdmin($id, $admin_id);
    }

    public function updateDataOnVerificationSuccess($id, $setStatus, $comment)
    {
        return $this->getVerifiedRepository->updateDataOnVerificationSuccess($id, $setStatus, $comment);
    }

    public function delete($user)
    {
        $verify = $this->getVerifiedRepository->get($user->id);
        if ($verify && $verify->identification_doc != '' && file_exists(storage_path('app/public/' . $verify->identification_doc))) {
            unlink(storage_path('app/public/' . $verify->identification_doc));
            $verify->delete();
        }
    }
}
