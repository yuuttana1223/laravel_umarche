<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, User $user)
    {
        $this->products = $products;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.thanks')
            ->subject('ご購入ありがとうございます。');
    }
}
