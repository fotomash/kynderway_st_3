<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserInterface;

use App\Models\User;

class UserRepository implements UserInterface
{
    public function getUser($id)
    {
        return User::find($id);
    }

    public function getUsers()
    {
        return User::with('videosets', 'userlanguages')
            ->where('type', '<>', 'admin')
            ->where('delete_request', 0)
            // ->whereNotNull('email_verified_at')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function assignAdminToUser($id, $admin_id)
    {
        User::where('id', $id)->update([
            'assign_user_id' => $admin_id
        ]);
    }

    public function getDeleteRequestUsers()
    {
        return User::with('videosets', 'userlanguages')
            ->where('type', '<>', 'admin')
            ->where('delete_request', 1)
            ->whereNotNull('email_verified_at')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getDeletedUsers()
    {
        return User::onlyTrashed()->with('videosets', 'userlanguages')->where('type', '<>', 'admin')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function updateUserNotes($id, $note)
    {
        User::where('id', $id)->update([
            'admin_notes' => $note
        ]);
    }

    public function updateUserPassword($id, $password)
    {
        User::where('id', $id)->update([
            'password' => Hash::make($password)
        ]);
    }

    public function updateBlockStatus($id, $status)
    {
        User::where('id', $id)->update([
            'is_block' => $status
        ]);
    }

    public function softDelete($id, $adminId)
    {
        User::where('id', $id)->update([
            'deleted_by' => $adminId,
            'deleted_type' => 'admin',
        ]);
        User::where('id', $id)->delete();
    }

    public function hardDelete($id, $random, $timestamp)
    {
        User::where('id', $id)->update([
            'name' => $random,
            'last_name' => $random,
            'email' => $timestamp,
            'phone' => $timestamp.$random.'@junk.com',
            'profile_picture' => '',
            'company_name' => '',
            'company_website' => '',
            'landmark' => '',
            'delete_request' => 2,
            'admin_notes' => '',
            'assign_user_id' => null,
        ]);
    }

    public function updateOTPDetails($user)
    {
        User::where('id', $user->id)->update([
            'otp' => rand(1000, 9999),
            'otp_send_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function updateDeleteRequest($id)
    {
        User::where('id', $id)->update([
            'delete_request' => 1
        ]);
    }
}
