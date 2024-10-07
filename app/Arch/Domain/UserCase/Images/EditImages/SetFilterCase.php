<?php

namespace App\Arch\Domain\UserCase\Images\EditImages;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\EditImages\SetFilterService;
use Illuminate\Support\Arr;

class SetFilterCase extends BaseUserCase implements BaseInterface {

    private SetFilterService $setFilterService;

    public function __construct() {
        parent::__construct();
        $this -> setFilterService = new SetFilterService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(), 'id'),
            'editType' => Arr::get($this -> getAttributes(), 'filter'),
            'user_id' => $this ->getUser() -> getAuthIdentifier(),
            'red' => Arr::get($this -> getAttributes(), 'red') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'red'),
            'green' => Arr::get($this -> getAttributes(), 'green') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'green'),
            'blue' => Arr::get($this -> getAttributes(), 'blue') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'blue'),
            'pixelation' => Arr::get($this -> getAttributes(), 'pixel_level') == null ? AppConstant::NOT_FOUND_VALUE : Arr::get($this -> getAttributes(), 'pixel_level'),
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> setFilterService -> execute();
        return $this;
    }
}
