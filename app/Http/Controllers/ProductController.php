<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductController extends Controller implements HasMiddleware{
	public static function middleware(): array{

		return [
			'auth:brand,supplier'
		];
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index(): JsonResponse{
		$products = Product::with('supplier', 'category')
						   ->get();

		return response()->json($products);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(){
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProductRequest $request): JsonResponse{
		$product = Product::create($request->validated());

		return response()->json($product, Response::HTTP_CREATED);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Product $product){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Product $product){
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateProductRequest $request, Product $product): JsonResponse{
		$product->update($request->validated());

		return response()->json($product);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Product $product): JsonResponse{
		$product->delete();
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}
}
