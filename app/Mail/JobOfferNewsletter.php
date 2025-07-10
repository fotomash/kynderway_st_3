<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobOfferNewsletter extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(private array $content)
    {
    }

    public function build(): self
    {
        return $this->subject('Kynderway - Jobs newsletter')
                    ->markdown('emails.job-offers-newsletter')
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()
                                ->addTextHeader('category', 'marketing newsletter');
                    })
                    ->with('content', $this->content);
    }
}
