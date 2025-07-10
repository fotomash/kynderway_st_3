<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendJobOffersMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->markdown('emails.job-offers')
                    ->with('content', $this->content);
    }
}
