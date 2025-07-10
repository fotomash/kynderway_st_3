<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
// use app/Notifications/EmailVerification;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\ProfilePostInterface', 'App\Repositories\ProfilePostRepository');
        $this->app->bind('App\Interfaces\UserConnectionsInterface', 'App\Repositories\UserConnectionsRepository');
        $this->app->bind('App\Interfaces\MessageInterface', 'App\Repositories\MessageRepository');
        $this->app->bind('App\Interfaces\ReportInterface', 'App\Repositories\ReportRepository');
        $this->app->bind('App\Interfaces\ReportUserInterface', 'App\Repositories\ReportUserRepository');
        $this->app->bind('App\Interfaces\ExperiencesInterface', 'App\Repositories\ExperiencesRepository');
        $this->app->bind('App\Interfaces\JobTypesInterface', 'App\Repositories\JobTypesRepository');
        $this->app->bind('App\Interfaces\SpecialitiesInterface', 'App\Repositories\SpecialitiesRepository');
        $this->app->bind('App\Interfaces\GetVerifiedInterface', 'App\Repositories\GetVerifiedRepository');
        $this->app->bind('App\Interfaces\UserInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Interfaces\JobPostInterface', 'App\Repositories\JobPostRepository');
        $this->app->bind('App\Interfaces\LanguageUserInterface', 'App\Repositories\LanguageUserRepository');
        $this->app->bind('App\Interfaces\VideoIntroInterface', 'App\Repositories\VideoIntroRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');

        view()->composer('*', function ($view) {
            $user_type = '';
            if (Auth::check() && Auth::user()->type == 'service_seeker') {
                $user_type = '/user/client';
            } elseif (Auth::check() && Auth::user()->type == 'service_provider') {
                $user_type = '/provider';
            }

            $view->with('user_type', $user_type);
        });

        // Override the email notification for verifying email
        // VerifyEmail::toMailUsing(function ($notifiable){
        //     $verifyUrl = URL::temporarySignedRoute(
        //         'verification.verify',
        //         Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //         ['id' => $notifiable->getKey()]
        //     );
        //     return new EmailVerification($verifyUrl, $notifiable);
        // });
    }
}
