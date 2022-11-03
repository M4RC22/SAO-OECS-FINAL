<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddOrganizationMemberEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orgName;
    public $position;
    public $role;

    public function __construct($orgName,  $position, $role)
    {
        $this->orgName = $orgName;
        $this->position = $position;
        $this->role = $role;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.add-organization-member-notification')
                    ->subject('You are added in the Student Organization');
    }
}
