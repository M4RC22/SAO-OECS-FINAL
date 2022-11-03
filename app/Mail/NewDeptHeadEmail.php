<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDeptHeadEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $dept;

    public function __construct($dept)
    {
        $this->dept = $dept;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.new-dept-head-notification')
                    ->subject('Department Head Position Assignment');
    }
}
