<?php

namespace App\Repositories;

use App\Interfaces\SpecialitiesInterface;

use App\Models\Specialities;

class SpecialitiesRepository implements SpecialitiesInterface
{
    public function getValuesForIds($ids)
    {
        return Specialities::whereIn('id', $ids)->pluck('name')->toArray();
    }
}
