<?php

namespace App\Arch\Domain\UserCase\Images\EditImages;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\EditImages\ResizeImagesService;
use Illuminate\Support\Arr;

class ResizeImageCase extends BaseUserCase implements BaseInterface {

    private ResizeImagesService $resizeImagesService;

    public function __construct() {
        parent::__construct();
        $this -> resizeImagesService = new ResizeImagesService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(), 'id'),
            'editType' => AppConstant::RESIZE_CODE,
            'width' => Arr::get($this -> getAttributes(), 'width'),
            'height' => Arr::get($this -> getAttributes(), 'height'),
            'user_id' => $this ->getUser() -> getAuthIdentifier()
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> resizeImagesService -> execute();
        return $this;
    }
}
