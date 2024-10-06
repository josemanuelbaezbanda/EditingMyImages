<?php

namespace App\Arch\Domain\UserCase\Auth;

use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Auth\LoginService;
use Illuminate\Support\Arr;

class LoginCase extends BaseUserCase implements BaseInterface {

    private LoginService $loginService;

    public function __construct() {
        parent::__construct();
        $this -> loginService = new LoginService($this);
    }
    public function transform(): array
    {
        return [
            'email' => Arr::get($this -> getAttributes(), 'email'),
            'password' => Arr::get($this -> getAttributes(), 'password')
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> loginService -> execute();
        return $this;
    }
}
