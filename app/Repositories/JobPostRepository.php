<?php

namespace App\Repositories;

use App\Interfaces\JobPostInterface;

use App\Models\Job_Posts;
use App\Models\Profile_Categories;

class JobPostRepository implements JobPostInterface
{
    public function getAll($id)
    {
        return Job_Posts::where('user_id', $id)->get();
    }

    public function delete($id)
    {
        Job_Posts::where('user_id', $id)->delete();
    }



    public function getCountries()
    {
        $result = [];

        $data = Job_Posts::with('userdetails', 'profilecategory')
                ->select(['country','city'])
                ->whereHas('userdetails')
                ->whereHas('profilecategory')
                ->orderBy('id', 'desc')
                ->get();


        foreach ($data as $item) {
            if (($result[$item['country']]??null) == null) {
                $result[$item['country']] = [];
            }
            $result[$item['country']][$item['city']] = $item['city'];
        }

        return $result;
    }
}
