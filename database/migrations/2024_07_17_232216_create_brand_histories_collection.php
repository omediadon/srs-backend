<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration{
	protected $connection = 'mongodb';

	/**
	 * Run the migrations.
	 */
	public function up(): void{
		Schema::connection($this->connection)
			  ->create('brand_histories', function(Blueprint $collection){
				  $collection->index('brand_id');
				  $collection->index('created_at');
				  $collection->index('updated_at');
			  });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void{
		Schema::connection($this->connection)
			  ->drop('brand_histories');
	}
};
