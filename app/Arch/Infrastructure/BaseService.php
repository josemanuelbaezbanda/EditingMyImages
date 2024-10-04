<?php

namespace App\Arch\Infrastructure;

use App\Arch\Domain\UserCase\BaseInterface;

abstract class BaseService {

    public BaseInterface $iterator;

    public function __construct(BaseInterface $iterator) {
        $this -> iterator = $iterator;
    }

    abstract public function execute();

}
