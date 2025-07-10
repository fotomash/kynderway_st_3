<?php

namespace App\Repositories;

use App\Interfaces\VideoIntroInterface;

use App\Models\Videointros;

class VideoIntroRepository implements VideoIntroInterface
{
    public function get($id)
    {
        Videointros::where('provider_id', $id)->first();
    }
}
