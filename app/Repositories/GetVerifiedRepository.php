<?php

namespace App\Repositories;

use App\Interfaces\GetVerifiedInterface;

use App\Models\Getverified;

class GetVerifiedRepository implements GetVerifiedInterface
{
    public function get($id)
    {
        return Getverified::find($id);
    }

    public function assignAdmin($id, $admin_id)
    {
        Getverified::where('id', $id)->update([
            'assigned_user_id' => $admin_id
        ]);
    }

    public function getVerificationHistory()
    {
        return Getverified::with('user')->where('status', '!=', '0')->orderBy('id', 'desc')->get();
    }

    public function getPendingProvidersRequests()
    {
        return Getverified::with('user')->where('status', '0')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function updateGetVerifiedNotes($id, $note)
    {
        Getverified::where('id', $id)->update([
            'user_notes' => $note
        ]);
    }

    public function updateDataOnVerificationSuccess($id, $status, $comment)
    {
        Getverified::where('id', $id)->update([
            'identification_doc' => "",
            'reference_doc' => "",
            'status' => $status,
            'comment' => $comment
        ]);
    }
}
