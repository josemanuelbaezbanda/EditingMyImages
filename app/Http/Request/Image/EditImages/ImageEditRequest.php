<?php

namespace App\Http\Request\Image\EditImages;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Images\EditImages\ResizeImageCase;
use App\Http\Request\BaseRequest;

class ImageEditRequest extends BaseRequest{

    private ResizeImageCase $resizeImageCase;

    private const VALIDATE_RESIZE_IMAGE = [
        'id' => 'required|numeric',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
    ];

    public function __construct(ResizeImageCase $resizeImageCase){
        parent::__construct();
        $this -> resizeImageCase = $resizeImageCase;
    }

    public function resizeImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_RESIZE_IMAGE);
        $this -> resizeImageCase -> setRequest($this -> getRequest());
        return $this -> resizeImageCase -> apply() -> getResponse();
    }
}
