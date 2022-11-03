<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrgApplicationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orgApplicant;

    public function __construct($orgApplicant)
    {
       $this->orgApplicant = $orgApplicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.org-application-notification')
                    ->subject('Organization Application');
    }
}
