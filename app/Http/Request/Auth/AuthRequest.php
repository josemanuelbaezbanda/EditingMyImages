<?php

namespace App\Http\Request\Auth;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Auth\LoginCase;
use App\Arch\Domain\UserCase\Auth\LogoutCase;
use App\Arch\Domain\UserCase\Auth\RefreshCase;
use App\Arch\Domain\UserCase\Auth\RegisterCase;
use App\Http\Request\BaseRequest;

class AuthRequest extends BaseRequest{

    private RefreshCase $refreshCase;
    private LoginCase $loginCase;
    private RegisterCase $registerCase;
    private LogoutCase $logoutCase;

    private const VALIDATE_USER_LOGIN = [
        'email' => 'required|email',
        'password' => 'required|string'
    ];

    private const VALIDATE_USER_REGISTER = [
        'name' => 'required|string',
        'email' => 'required|email|max:100',
        'password' => 'required|string|min:0'
    ];

    public function __construct(LoginCase $loginCase, RegisterCase $registerCase, LogoutCase $logoutCase, RefreshCase $refreshCase){
        parent::__construct();
        $this -> loginCase = $loginCase;
        $this -> registerCase = $registerCase;
        $this -> logoutCase = $logoutCase;
        $this -> refreshCase = $refreshCase;
    }

    public function loginUser(): BaseResponse{
        $this -> applyRules(self::VALIDATE_USER_LOGIN);
        $this -> loginCase -> setRequest($this -> getRequest());
        return $this -> loginCase -> apply() -> getResponse();
    }

    public function registerUser(): BaseResponse{
        $this -> applyRules(self::VALIDATE_USER_REGISTER);
        $this -> registerCase -> setRequest($this -> getRequest());
        return $this -> registerCase -> apply() -> getResponse();
    }

    public function logoutUser(): BaseResponse{
        return $this -> logoutCase -> apply() -> getResponse();
    }
    public function refreshToken(): BaseResponse{
        return $this -> refreshCase -> apply() -> getResponse();
    }
}
