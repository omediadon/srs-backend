<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
	/**
	 * Run the migrations.
	 */
	public function up(): void{
		Schema::create('products', static function(Blueprint $table){
			$table->uuid('id')
				  ->primary();
			$table->string('name');
			$table->text('description');
			$table->uuid('category_id');
			$table->uuid('supplier_id');
			$table->json('colors')
				  ->nullable();
			$table->boolean('visibility')
				  ->default(false);
			$table->float('price')
				  ->nullable();
			$table->string('main_picture')
				  ->nullable();
			$table->timestamps();

			$table->foreign('category_id')
				  ->references('id')
				  ->on('categories')
				  ->onDelete('cascade');
			$table->foreign('supplier_id')
				  ->references('id')
				  ->on('suppliers')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void{
		Schema::dropIfExists('products');
	}
};
