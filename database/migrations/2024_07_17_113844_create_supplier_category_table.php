<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
	/**
	 * Run the migrations.
	 */
	public function up(): void{
		Schema::create('category_supplier', static function(Blueprint $table){
			$table->foreignUuid('supplier_id')
				  ->constrained()
				  ->cascadeOnDelete();
			$table->foreignUuid('category_id')
				  ->constrained()
				  ->cascadeOnDelete();
			$table->timestamps();

			$table->unique([
							   'supplier_id',
							   'category_id'
						   ]);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void{
		Schema::dropIfExists('supplier_category');
	}
};
