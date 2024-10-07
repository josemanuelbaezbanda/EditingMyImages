<?php

namespace App\Arch\Domain\UserCase\Images\EditImages;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\EditImages\SetFilterService;
use App\Arch\Infrastructure\Images\EditImages\SetTextService;
use Illuminate\Support\Arr;

class SetTextCase extends BaseUserCase implements BaseInterface {

    private SetTextService $setTextService;

    public function __construct() {
        parent::__construct();
        $this -> setTextService = new SetTextService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(), 'id'),
            'editType' => AppConstant::SET_TEXT_CODE,
            'user_id' => $this -> getUser() -> getAuthIdentifier(),
            'text' => Arr::get($this -> getAttributes(), 'text'),
            'xLocation' => Arr::get($this -> getAttributes(), 'x_location'),
            'yLocation' => Arr::get($this -> getAttributes(), 'y_location'),
            'size' => Arr::get($this -> getAttributes(), 'size') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'size'),
            'color' => Arr::get($this -> getAttributes(), 'color') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'color'),
            'stroke' => Arr::get($this -> getAttributes(), 'stroke') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'stroke'),
            'lineHeight' => Arr::get($this -> getAttributes(), 'line_height') == null ? AppConstant::ZERO_VALUE : Arr::get($this -> getAttributes(), 'line_height'),
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> setTextService -> execute();
        return $this;
    }
}
