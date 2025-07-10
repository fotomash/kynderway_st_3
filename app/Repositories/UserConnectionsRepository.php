<?php

namespace App\Repositories;

use App\Interfaces\UserConnectionsInterface;

use App\Models\User_Connections;

class UserConnectionsRepository implements UserConnectionsInterface
{
    public function delete($id)
    {
        return User_Connections::where('providerprofileid', $id)->delete();
    }

    public function getAll($id)
    {
        return User_Connections::where('providerprofileid', $id)->get();
    }

    public function deleteJobUserId($id)
    {
        User_Connections::where('job_userid', $id)->delete();
    }

    public function deleteProviderId($id)
    {
        User_Connections::where('provider_id', $id)->delete();
    }
}
