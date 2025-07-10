<?php

namespace App\Interfaces;

interface GetVerifiedInterface
{
    public function get($id);

    public function assignAdmin($id, $admin_id);

    public function getVerificationHistory();

    public function getPendingProvidersRequests();

    public function updateGetVerifiedNotes($id, $note);

    public function updateDataOnVerificationSuccess($id, $status, $comment);
}
