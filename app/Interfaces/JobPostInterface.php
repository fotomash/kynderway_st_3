<?php

namespace App\Interfaces;

interface JobPostInterface
{
    public function getAll($id);

    public function delete($id);

    public function getCountries();
}
