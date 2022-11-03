<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemoveOrganizationMemberEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orgName;

    public function __construct($orgName)
    {
        $this->orgName = $orgName;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.remove-organization-member-notification')
                    ->subject('You have been removed in the Student Organization');
    }
}
