<?php

namespace App\Interfaces;

interface ProfilePostInterface
{
    public function get($id);

    public function getWith($id);

    public function getAll();

    public function getCountByCategorty();

    public function getCountProviderWithoutWorkProfile();

    public function getEmailByCategorty(array $categories);

    public function getEmailsProviderWithoutWorkProfile();

    public function assignAdmin($id, $adminId);

    public function updateNotes($id, $notes);

    public function suspendActivate($id, $status, $suspendedBy);

    public function selectedProfileCount($category);

    public function updateSelectProfile($id, $select);

    public function delete($id);

    public function deleteProviderId($id);

    public function updateEducationDesc($id);
}
