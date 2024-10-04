<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Request\Auth\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRequest $request;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthRequest $authRequest)
    {
        $this -> request = $authRequest;
    }

    /**
     * Logeo del usuario al sistema
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> loginUser();
        return $this -> getResponse($response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $response = $this -> request -> logoutUser();
        return $this -> getResponse($response);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $response = $this -> request -> refreshToken();
        return $this -> getResponse($response);
    }

    /**
     * @param Request $args
     * @return JsonResponse
     */
    public function register(Request $args)
    {
        $this -> request -> setRequest($args);
        $response = $this -> request -> registerUser();
        return $this -> getResponse($response);
    }
}
