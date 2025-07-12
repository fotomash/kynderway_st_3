<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\ProfileDelete;
use App\Events\ProfileActivate;
use App\Events\JobDelete;
use App\Events\ProfileSuspend;
use App\Events\AccountSuspend;
use App\Events\AccountActivate;
use App\Events\SendJobOfferEvent;
use App\Events\UserVerificationApproved;
use App\Events\UserVerificationRejected;
use App\Events\UserAccountDeleteEvent;
use App\Events\UserDeleteEmailAdminEvent;
use App\Events\CreditsPurchased;
use App\Events\CreditsUsed;
use App\Events\PaymentProcessed;

use App\Listeners\SendJobDeleteMail;
use App\Listeners\SendProfileActivateMail;
use App\Listeners\SendProfileDeleteMail;
use App\Listeners\SendProfileSuspendMail;
use App\Listeners\SendAccountSuspendMail;
use App\Listeners\SendAccountActivateMail;
use App\Listeners\SendJobOfferListener;
use App\Listeners\SendUserVerificationApprovedMail;
use App\Listeners\SendUserVerificationRejectedMail;
use App\Listeners\SendUserAccountDeleteMail;
use App\Listeners\SendUserDeleteAdminMail;
use App\Listeners\SendCreditPurchaseNotification;
use App\Listeners\UpdateUserCreditsBalance;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProfileSuspend::class => [
            SendProfileSuspendMail::class,
        ],
        ProfileActivate::class => [
            SendProfileActivateMail::class,
        ],
        JobDelete::class => [
            SendJobDeleteMail::class,
        ],
        ProfileDelete::class => [
            SendProfileDeleteMail::class,
        ],
        AccountSuspend::class => [
            SendAccountSuspendMail::class,
        ],
        AccountActivate::class => [
            SendAccountActivateMail::class,
        ],
        UserVerificationApproved::class => [
            SendUserVerificationApprovedMail::class,
        ],
        UserVerificationRejected::class => [
            SendUserVerificationRejectedMail::class,
        ],
        UserAccountDeleteEvent::class => [
            SendUserAccountDeleteMail::class,
        ],
        UserDeleteEmailAdminEvent::class => [
            SendUserDeleteAdminMail::class,
        ],
        SendJobOfferEvent::class => [
            SendJobOfferListener::class,
        ],
        CreditsPurchased::class => [
            SendCreditPurchaseNotification::class,
            UpdateUserCreditsBalance::class,
        ],
        CreditsUsed::class => [
            UpdateUserCreditsBalance::class,
        ],
        PaymentProcessed::class => [],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
