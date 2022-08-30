<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSale extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private string $context;
    private string $name;

    public function __construct(string $name, string $context)
    {
        $this->name = $name;
        $this->context = $context;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【' . config('mail.subject') . ']')
            ->markdown('mail.sale_mail')->with([
                'name' => $this->name,
                'context' => $this->context,
            ]);
    }
}
