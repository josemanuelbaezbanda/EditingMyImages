<?php

namespace App\Arch\Domain\UserCase\Auth;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Auth\LoginService;
use App\Arch\Infrastructure\Auth\RegisterService;
use Illuminate\Support\Arr;

class RegisterCase extends BaseUserCase implements BaseInterface {

    private RegisterService $registerService;

    public function __construct() {
        parent::__construct();
        $this -> registerService = new RegisterService($this);
    }
    public function transform(): array
    {
        return [
            'name' => Arr::get($this -> getAttributes(), "name"),
            'email' => Arr::get($this -> getAttributes(), 'email'),
            'password' => bcrypt(Arr::get($this -> getAttributes(), 'password')),
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> registerService -> execute();
        return $this;
    }
}
