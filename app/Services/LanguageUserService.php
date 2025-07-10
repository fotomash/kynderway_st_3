<?php

namespace App\Services;

use App\Interfaces\LanguageUserInterface;

class LanguageUserService
{
    private $languageUserRepository;

    public function __construct(LanguageUserInterface $languageUserRepository)
    {
        $this->languageUserRepository = $languageUserRepository;
    }

    public function delete($user)
    {
        return $this->languageUserRepository->delete($user->id);
    }
}
