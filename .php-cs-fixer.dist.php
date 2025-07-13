<?php
$finder = PhpCsFixer\Finder::create()
    ->append([
        __DIR__.'/app/Events/BookingCreated.php',
        __DIR__.'/app/Listeners/SendBookingNotification.php',
        __DIR__.'/app/Providers/EventServiceProvider.php',
        __DIR__.'/app/Services/BookingService.php',
    ]);

return (new PhpCsFixer\Config())
    ->setRules(['@PSR12' => true])
    ->setFinder($finder);
