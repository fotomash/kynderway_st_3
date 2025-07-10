<?php

namespace App\Repositories;

use App\Interfaces\LanguageUserInterface;

use App\Models\User_Language;

class LanguageUserRepository implements LanguageUserInterface
{
    public function delete($id)
    {
        User_Language::where('user_id', $id)->delete();
    }
}
