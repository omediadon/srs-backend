<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
	/**
	 * Run the migrations.
	 */
	public function up(): void{
		Schema::create('supplier_category', static function(Blueprint $table){
			$table->uuid('supplier_id');
			$table->uuid('category_id');
			$table->primary([
								'supplier_id',
								'category_id'
							]);

			$table->foreign('supplier_id')
				  ->references('id')
				  ->on('suppliers')
				  ->onDelete('cascade');
			$table->foreign('category_id')
				  ->references('id')
				  ->on('categories')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void{
		Schema::dropIfExists('supplier_category');
	}
};
