<?php

namespace App\Arch\Infrastructure\Auth;

use App\Arch\Infrastructure\BaseService;

class LoginService extends BaseService{

    public function execute()
    {
        $credentials = $this -> iterator ->transform();

        if (! $token = auth('api')->attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $this -> iterator -> feedback(['access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60]);
    }

}
