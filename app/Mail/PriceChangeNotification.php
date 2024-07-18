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

class PriceChangeNotification extends Mailable{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public Brand $brand, public Product $product, public float $oldPrice,
								public float $currentPrice){
		//
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope{
		return new Envelope(subject: 'Product Price Change Notification',);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content{
		return new Content(view: 'emails.price-change',);
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
