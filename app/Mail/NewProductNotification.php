<?php

namespace App\Mail;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProductNotification extends Mailable{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public Brand $brand, public Product $product){
		//
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope{
		return new Envelope(subject: 'New Product Notification',);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content{
		return new Content(view: 'emails.new-product',);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, Attachment>
	 */
	public function attachments(): array{
		return [];
	}
}
