<?php

namespace App\Repositories;

use App\Interfaces\ProfilePostInterface;

use App\Models\Profile_Posts;
use Illuminate\Support\Facades\DB;

class ProfilePostRepository implements ProfilePostInterface
{
    public function get($id)
    {
        return Profile_Posts::where('id', $id)->first();
    }

    public function getCountByCategorty()
    {
        return DB::table('profile_posts')
                ->selectRaw('profile_posts.profile_category_id, profile_categories.categoryname, count(*) as users')
                ->leftJoin('profile_categories', 'profile_posts.profile_category_id', '=', 'profile_categories.id')
                ->leftJoin('users', 'profile_posts.provider_id', '=', 'users.id')
                ->where('users.marketing', '=', 1)
                ->groupBy('profile_posts.profile_category_id')->get()->toArray();
    }

    public function getCountProviderWithoutWorkProfile()
    {
        $providersWithProfileCount = DB::table('profile_posts')
                            ->selectRaw('count(DISTINCT profile_posts.provider_id) as count')
                            ->leftJoin('users', 'profile_posts.provider_id', '=', 'users.id')
                            ->where('users.marketing', '=', 1)->get();


        $allProvidersCount = DB::table('users')
        ->selectRaw('count(*) as count')
        ->where('users.marketing', '=', 1)
        ->where('users.type', '=', 'service_provider')
        ->get();
        return $allProvidersCount[0]->count - $providersWithProfileCount[0]->count;
    }

    public function getEmailByCategorty(array $categories)
    {
        return DB::table('profile_posts')
                ->selectRaw("users.email as email, CONCAT(users.name,' ',users.last_name) as username")
                ->leftJoin('users', 'profile_posts.provider_id', '=', 'users.id')
                ->where('users.marketing', '=', 1)
                ->whereIn('profile_posts.profile_category_id', $categories)
                ->get()->toArray();
    }

    public function getEmailsProviderWithoutWorkProfile()
    {
        $providersWithProfile = DB::table('profile_posts')
                            ->selectRaw('profile_posts.provider_id as ids')
                            ->leftJoin('users', 'profile_posts.provider_id', '=', 'users.id')
                            ->where('users.marketing', '=', 1)->get();


        $allProviders = DB::table('users')
        ->selectRaw("users.email as email, CONCAT(users.name,' ',users.last_name) as username")
            ->where('users.marketing', '=', 1)
            ->where('users.type', '=', 'service_provider')
            ->whereNotIn('id', array_column($providersWithProfile->toArray(), 'ids'))
            ->get();
        return $allProviders->toArray();
    }

    public function getWith($id)
    {
        return Profile_Posts::where('id', $id)
            ->with('userdetails', 'userdetails.userlanguages', 'userdetails.getVerified')
            ->first();
    }

    public function getAll()
    {
        return Profile_Posts::with('userdetails', 'profilecat')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function assignAdmin($profilePostId, $adminId)
    {
        Profile_Posts::where('id', $profilePostId)->update([
            'assigned_user_id' => $adminId
        ]);
    }

    public function updateNotes($id, $notes)
    {
        Profile_Posts::where('id', $id)->update([
            'user_notes' => $notes
        ]);
    }

    public function suspendActivate($id, $status, $suspendedBy)
    {
        Profile_Posts::where('id', $id)->update([
            'status' => $status,
            'suspendBy' => $suspendedBy
        ]);
    }

    public function selectedProfileCount($category)
    {
        return Profile_Posts::where([
            ['selected', 1],
            ['profile_category_id', $category],
        ])->count();
    }

    public function updateSelectProfile($id, $select)
    {
        return Profile_Posts::where('id', $id)->update([
            'selected' => $select
        ]);
    }

    public function delete($id)
    {
        Profile_Posts::where('id', $id)->delete();
    }

    public function deleteProviderId($id)
    {
        Profile_Posts::where('provider_id', $id)->delete();
    }

    public function updateEducationDesc($id)
    {
        Profile_Posts::where('provider_id', $id)->update(['edu_description' => '']);
    }
}
