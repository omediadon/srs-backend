<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool{
		// Just for the demo!
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array{
		return [
			'name'         => 'required|string|max:255',
			'description'  => 'required|string',
			'category_id'  => 'required|exists:categories,id',
			'supplier_id'  => 'required|exists:suppliers,id',
			'colors'       => 'required|array',
			'visibility'   => 'required|boolean',
			'price'        => 'required|numeric|min:0',
			'main_picture' => 'required|string',
		];
	}
}
