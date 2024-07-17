<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Supplier;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller implements HasMiddleware{
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct(){}

	public static function middleware(): array{

		return [
			new Middleware('auth:api,brand,supplier', [
				'except' => [
					'login',
					'register'
				]
			])
		];
	}

	/**
	 * @return string|null
	 */
	protected function guardName(): ?string{
		if(Auth::guard('brand')
			   ->check()){
			return 'brand';
		}
		if(Auth::guard('supplier')
			   ->check()){
			return 'supplier';
		}
		// Users/api guard as a fallback
		if(Auth::guard('api')
			   ->check()){
			return 'api';
		}

		return null;
	}

	/**
	 * Return an instance
	 * @return Guard|StatefulGuard
	 */
	protected function guard(){
		return Auth::guard($this->guardName());
	}

	/**
	 * Get a JWT via given credentials.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function login(Request $request): JsonResponse{
		$validator = Validator::make($request->all(), [
			'email'     => 'required|email',
			'password'  => 'required|string',
			'user_type' => 'required|in:brand,supplier,api',
		]);

		if($validator->fails()){
			return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$credentials = $request->only('email', 'password');
		$guard       = $request->user_type;

		if($token = Auth::guard($guard)
						->attempt($credentials)){
			return $this->respondWithToken($token, $guard);
		}

		return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
	}

	/**
	 * Get the token array structure.
	 *
	 * @param string $token
	 *
	 * @return JsonResponse
	 */
	protected function respondWithToken(string $token, ?string $guard = null): JsonResponse{
		$tokenData = [
			'access_token' => $token,
			'token_type'   => 'bearer',
			'expires_in'   => Auth::guard($guard)
								  ->factory()
								  ->getTTL() * 60,
			'user_type'    => $guard
		];

		return response()->json($tokenData);
	}

	/**
	 * Register a new user.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function register(Request $request): JsonResponse{
		$validator = Validator::make($request->all(), [
			'name'        => [
				'required',
				'string',
				'max:255'
			],
			'email'       => [
				'required',
				'string',
				'email',
				'max:255'
			],
			'password'    => [
				'required',
				'confirmed',
				Password::defaults()
			],
			'address'     => [
				'required_if:user_type,brand',
				'string'
			],
			'user_type'   => [
				'required',
				'in:brand,supplier,api'
			],
			'category_id' => [
				'required_if:user_type,brand',
				'exists:categories,id'
			],
			'phone'       => [
				'required_if:user_type,supplier',
				'string'
			],
			'logo'        => [
				'required_if:user_type,brand',
				'string'
			],
		]);

		if($validator->fails()){
			return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$userData = [
			'name'     => $request->name,
			'email'    => $request->email,
			'password' => Hash::make($request->password),
			'address'  => $request->address,
			'logo'     => $request->logo,
		];

		if($request->user_type === 'brand'){
			$userData['category_id'] = $request->category_id;
			Brand::create($userData);
		}
		elseif($request->user_type === 'supplier'){
			$userData['phone'] = $request->phone;
			Supplier::create($userData);
		}
		else{
			User::create($userData);
		}

		return response()->json(['message' => 'Successfully registered'], Response::HTTP_CREATED);
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return JsonResponse
	 */
	public function me(): JsonResponse{
		return response()->json(auth()->user());
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return JsonResponse
	 */
	public function logout(): JsonResponse{
		$this->guard()
			 ->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	/**
	 * Refresh a token.
	 *
	 * @return JsonResponse
	 */
	public function refresh(): JsonResponse{
		return $this->respondWithToken(auth()->refresh());
	}
}
