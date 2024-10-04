<?php

namespace App\Arch\Domain\UserCase;

interface BaseInterface {

    public function transform() : array;

    public function feedback(mixed $response);

}
