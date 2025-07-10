<?php

namespace App\Repositories;

use App\Interfaces\ReportUserInterface;

use App\Models\ReportUser;

class ReportUserRepository implements ReportUserInterface
{
    public function updateStatus($id, $status)
    {
        return ReportUser::where('report_id', $id)->update(['status' => $status]);
    }
}
