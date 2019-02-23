<?php

namespace Workload\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BidApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $handyman;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($handyman)
    {
        $this->user = $handyman;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.bid_approval');
    }
}
