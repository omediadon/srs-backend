<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array{
		return [
			'name'         => 'string|max:255',
			'description'  => 'string',
			'category_id'  => 'exists:categories,id',
			'supplier_id'  => 'exists:suppliers,id',
			'colors'       => 'array',
			'visibility'   => 'boolean',
			'price'        => 'numeric|min:0',
			'main_picture' => 'string',
		];
	}
}
