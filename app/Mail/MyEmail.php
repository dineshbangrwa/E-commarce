<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Myemail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $orderItems;

    public function __construct($user, $order, $orderItems)
    {
        $this->user = $user;
        $this->order = $order;
        $this->orderItems = $orderItems;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.mymail',
            with: [
                'user' => $this->user,
                'order' => $this->order,
                'orderItems' => $this->orderItems,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
