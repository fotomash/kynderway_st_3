<?php

namespace App\Interfaces;

interface UserConnectionsInterface
{
    public function getAll($id);

    public function delete($id);

    public function deleteJobUserId($id);

    public function deleteProviderId($id);
}
