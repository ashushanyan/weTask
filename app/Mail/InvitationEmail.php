<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @param $sender
     * @param $getter
     */
    public function __construct($sender, $getter, $board)
    {
        $this->data['sender'] = $sender;
        $this->data['getter'] = $getter;
        $this->data['board']  = $board;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data['getter']['email'])
            ->view('emails.invitationMail')
            ->subject('validate')
            ->with('data', $this->data);
    }
}
