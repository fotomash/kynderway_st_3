<?php

namespace App\Repositories;

use App\Interfaces\ReportInterface;

use App\Models\Report;

class ReportRepository implements ReportInterface
{
    public function updateStatus($id, $status)
    {
        return Report::where('profile_post_id', $id)->where('type', 'Profile')->update(['status' => $status]);
    }
}
