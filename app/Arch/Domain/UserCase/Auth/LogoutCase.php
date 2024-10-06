<?php

namespace App\Arch\Domain\UserCase\Auth;

use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Auth\LogoutService;

class LogoutCase extends BaseUserCase implements BaseInterface {

    private LogoutService $logoutService;

    public function __construct() {
        parent::__construct();
        $this -> logoutService = new LogoutService($this);
    }
    public function transform(): array
    {
        return [];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> logoutService -> execute();
        return $this;
    }
}
