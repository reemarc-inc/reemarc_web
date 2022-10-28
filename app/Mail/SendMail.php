<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = [
            'due'           => '10-28-2022',
            'who'           => 'Wendy',
            'c_id'          => '1229',
            'a_id'          => '3993',
            'task_name'     => 'imPRESS | E-Comm | Saving Bundle: Decorated Nails',
            'asset_type'    => 'email_blast',
            'asset_status'  => 'copy_request',
            'url' => '/admin/campaign/1229/edit#3993'
        ];

        return $this->markdown('emails.due.due_date_after')->with('details', $details);
    }

    public function email_send()
    {

//        Mail::to('jilee2@kissusa.com')->send(new SendMail());
        return new SendMail();
    }


}
