<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller implements HasMiddleware{
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct(){}

	public static function middleware(): array{

		return [
			new Middleware('auth:api', [
				'except' => [
					'login',
					'register'
				]
			])
		];
	}

	/**
	 * Get a JWT via given credentials.
	 *
	 * @return JsonResponse
	 */
	public function login(): JsonResponse{
		$credentials = request([
								   'email',
								   'password'
							   ]);

		if(!$token = auth()->attempt($credentials)){
			return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
		}

		return $this->respondWithToken($token);
	}

	/**
	 * Get the token array structure.
	 *
	 * @param string $token
	 *
	 * @return JsonResponse
	 */
	protected function respondWithToken($token): JsonResponse{
		return response()->json([
									'access_token' => $token,
									'token_type'   => 'bearer',
									'expires_in'   => auth()
											->factory()
											->getTTL() * 60
								]);
	}

	/**
	 * Register a new user.
	 *
	 * @return JsonResponse
	 */
	public function register(Request $request): JsonResponse{
		$validator = Validator::make($request->all(), [
			'name'     => 'required|string|max:255',
			'email'    => 'required|string|email|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);

		if($validator->fails()){
			return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		User::create($request->all());

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
		auth()->logout();

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
