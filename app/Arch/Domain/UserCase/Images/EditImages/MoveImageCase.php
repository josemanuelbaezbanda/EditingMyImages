<?php

namespace App\Arch\Domain\UserCase\Images\EditImages;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\EditImages\MoveImagerService;
use Illuminate\Support\Arr;

class MoveImageCase extends BaseUserCase implements BaseInterface {

    private MoveImagerService $moveImagerService;

    public function __construct() {
        parent::__construct();
        $this -> moveImagerService = new MoveImagerService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(), 'id'),
            'editType' => Arr::get($this -> getAttributes(), 'filter'),
            'user_id' => $this ->getUser() -> getAuthIdentifier(),
            'rotation' => Arr::get($this -> getAttributes(), 'rotation') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'rotation')
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> moveImagerService -> execute();
        return $this;
    }
}
