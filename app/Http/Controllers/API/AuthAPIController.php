<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AUTH\LoginAPIRequest;
use App\Http\Requests\AUTH\RegisterAPIRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthAPIController extends Controller
{
    /**
     * Register a new user and provide access token
     *
     * @group AuthAPI
     * @request POST
     * @urlParam http://localhost/api/users
     * @bodyParam email string Example: janedoe@example.com
     * @bodyParam password string Example: janebabe1
     *
     * @response {
     *      "access_token": "3|LqivO8LnSBdUkZcPLeCl0oa8gT7NgbSEL5Wnafen",
     *      "token_type": "Bearer"
     *  }
     *
     * @param RegisterAPIRequest $request
     * @return JsonResponse
     */
    public function register(RegisterAPIRequest $request): JsonResponse
    {
        $post_data = $request->validated();
        $user = User::create([
            'email' => $post_data['email'],
            'password' => Hash::make($post_data['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Authorize log-in attempt and provide access token
     *
     * @group AuthAPI
     * @request POST
     * @urlParam http://localhost/api/users
     * @bodyParam email string Example: admin@plums.com
     * @bodyParam password string Example: Password1
     *
     * @response {
     *      "access_token": "1|DMBY2ExTjNoAtTtFP8mTM6mZATcMRkgMiqHg511E",
     *      "token_type": "Bearer"
     * }
     *
     * @param LoginAPIRequest $request
     * @return JsonResponse
     */
    public function login(LoginAPIRequest $request): JsonResponse
    {
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json([
                    'message' => 'Log-in information is invalid.'
                ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
    }

    /**
     * Log user out of system
     *
     * @group AuthAPI
     * @request POST
     * @urlParam http://localhost/api/logout
     *
     * @response {
     *      "message": "You are now logged-out"
     *  }
     *
     * @param Request $request
     * @return string[]
     */
    public function logout(Request $request): array
    {
        auth()->user()->currentAccessToken()->delete();

        return [
            'message' => 'You are now logged-out'
        ];
    }
}
