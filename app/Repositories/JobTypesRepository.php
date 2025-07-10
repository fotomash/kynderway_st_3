<?php

namespace App\Repositories;

use App\Interfaces\JobTypesInterface;

use App\Models\Job_Types;

class JobTypesRepository implements JobTypesInterface
{
    public function getValuesForIds($ids)
    {
        return Job_Types::whereIn('id', $ids)->pluck('jobtype')->toArray();
    }
}
