<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductPriceChanged{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 */
	public function __construct(public Product $product, public float $oldPrice, public float $currentPrice){
		//
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, Channel>
	 */
	public function broadcastOn(): array{
		return [
			new PrivateChannel('channel-name'),
		];
	}
}
