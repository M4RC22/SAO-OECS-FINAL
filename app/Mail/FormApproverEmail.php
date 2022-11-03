<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormApproverEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $formType;
    public $formTitle;

    public function __construct($formType, $formTitle)
    {
        $this->formType = $formType;
        $this->formTitle = $formTitle;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.form-approver-notification')
        ->subject('Form ready to be reviewed');
    }
}
