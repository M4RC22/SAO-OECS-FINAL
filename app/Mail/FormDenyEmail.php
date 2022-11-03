<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormDenyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $formType;
    public $formTitle;
    public $formRemarks;

    public function __construct($formType, $formTitle, $formRemarks)
    {
        $this->formType = $formType;
        $this->formTitle = $formTitle;
        $this->formRemarks = $formRemarks;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.form-deny-notification')
                    ->subject('Forms Denied');
    }
}
