<?php

namespace App\Arch\Domain\UserCase\Auth;

use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Auth\RefreshService;

class RefreshCase extends BaseUserCase implements BaseInterface {

    private RefreshService $refreshService;

    public function __construct() {
        parent::__construct();
        $this -> refreshService = new RefreshService($this);
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
        $this -> refreshService -> execute();
        return $this;
    }
}
