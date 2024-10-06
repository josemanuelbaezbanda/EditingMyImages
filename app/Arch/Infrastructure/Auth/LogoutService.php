<?php

namespace App\Arch\Infrastructure\Auth;

use App\Arch\Infrastructure\BaseService;

class LogoutService extends BaseService{

    public function execute()
    {
        auth()->logout();

        $this -> iterator ->feedback(true);
    }

}
