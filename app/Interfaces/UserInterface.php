<?php

namespace App\Interfaces;

interface UserInterface
{
    public function getUser($id);

    public function getUsers();

    public function assignAdminToUser($id, $admin_id);

    public function getDeleteRequestUsers();

    public function getDeletedUsers();

    public function updateUserNotes($id, $note);

    public function updateUserPassword($id, $password);

    public function updateBlockStatus($id, $status);

    public function softDelete($id, $adminId);

    public function hardDelete($id, $random, $timestamp);

    public function updateOTPDetails($user);

    public function updateDeleteRequest($id);
}
