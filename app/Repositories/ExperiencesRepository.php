<?php

namespace App\Repositories;

use App\Interfaces\ExperiencesInterface;

use App\Models\Experiences;

class ExperiencesRepository implements ExperiencesInterface
{
    public function getValuesForIds($ids)
    {
        return Experiences::whereIn('id', $ids)->pluck('exp_name')->toArray();
    }
}
