<?php

namespace App\Arch\Infrastructure\Auth;

use App\Arch\Infrastructure\BaseService;

class RefreshService extends BaseService{

    public function execute()
    {
        $this -> iterator -> feedback(['access_token' => auth() -> refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60]);
    }

}
