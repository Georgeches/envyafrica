<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public $customer;

    public function __construct(Order $order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $date = Carbon::now();
        $dateFormatted = $date->format('d F Y');
        
        return new Content(
            view: 'mails.orderReceived',
            with: [
                'order' => $this->order,
                'customer' => $this->customer,
                'date' => $dateFormatted
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
