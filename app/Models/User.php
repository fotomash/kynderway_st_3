<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Review;
use App\Traits\Geocodable;

use App\Notifications\UserVerificationEmail;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", description="User ID"),
 *     @OA\Property(property="name", type="string", description="User name"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp")
 * )
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use \App\Traits\Geocodable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'type',
        'client_type',
        'phone_code',
        'phone',
        'secondary_notifications',
        'is_private',
        'country',
        'nationality',
        'state',
        'city',
        'postal_code',
        'landmark',
        'profile_picture',
        'avatar',
        'address',
        'latitude',
        'longitude',
        'native_language',
        'birth_date',
        'company_name',
        'company_website',
        'email',
        'password',
        'provider',
        'provider_id',
        'fcm_token',
        'assign_user_id',
        'deleted_by',
        'deleted_type',
        'delete_request',
        'otp',
        'otp_send_at',
        'is_new',
        'credits',
        'ssn',
        'checkr_candidate_id',
        'background_check_report_id',
        'background_check_status',
        'background_check_initiated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ssn',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'background_check_initiated_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserVerificationEmail());
        return 1;
    }

    public function profileposts()
    {
        return $this->hasMany(Profile_Posts::class, 'provider_id', 'id');
    }

    public function jobPosts()
    {
        return $this->hasMany(Job_Posts::class);
    }

    public function userlanguages()
    {
        return $this->hasMany(User_Language::class, 'user_id');
    }

    public function videosets()
    {
        return $this->hasMany(Videointros::class, 'provider_id');
    }

    public function getVerified()
    {
        return $this->hasOne(Getverified::class, 'provider_id')->latest();
    }

    public function assigned()
    {
        return $this->belongsto(User::class, 'assign_user_id', 'id');
    }

    public function assignedUser()
    {
        return $this->hasMany(User::class, 'id', 'assign_user_id');
    }

    public function myJobs()
    {
        return $this->hasMany(User::class, 'user_id', 'assigned_user_id');
    }

    public function myProfiles()
    {
        return $this->hasMany(User::class, 'provider_id', 'assigned_user_id');
    }

    public function myVerification()
    {
        return $this->hasMany(User::class, 'provider_id', 'assigned_user_id');
    }

    public function reports()
    {
        return $this->hasMany(ReportUser::class);
    }
    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, "reviewer_id");
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, "reviewee_id");
    }

    public function credits()
    {
        return $this->hasOne(UserCredit::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function unlockedProfiles()
    {
        return $this->hasMany(UnlockedProfile::class, 'parent_id');
    }


    public function deletedby()
    {
        return $this->belongsto(User::class, 'deleted_by', 'id');
    }

    /**
     * Scope a query to users near the given coordinates within the radius (miles).
     */
    public function scopeNearby($query, array $location, $radius = 20)
    {
        $lat = $location['lat'] ?? null;
        $lng = $location['lng'] ?? null;

        if ($lat === null || $lng === null) {
            return $query;
        }

        if (config('database.default') === 'sqlite') {
            $haversine = '(3959 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))';

            return $query->select('*')
                ->selectRaw("{$haversine} as distance_miles", [$lat, $lng, $lat])
                ->whereRaw("{$haversine} <= ?", [$lat, $lng, $lat, $radius])
                ->orderBy('distance_miles');
        }

        return $query->select('*')
            ->selectRaw(
                'ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) / 1609.34 as distance_miles',
                [$lng, $lat]
            )
            ->whereRaw(
                'ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) <= ?',
                [$lng, $lat, $radius * 1609.34]
            )
            ->orderBy('distance_miles');
    }
}
