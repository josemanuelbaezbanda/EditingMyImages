<?php

namespace App\Arch\Infrastructure;

use App\Models\User;
use Illuminate\Support\Arr;

trait UserHelper
{
    private function getUserAttribute(int $idUser, string $attribute) : mixed {
        $user = User::find($idUser) -> get() -> toArray();
        return Arr::first($user, $attribute);
    }

}
