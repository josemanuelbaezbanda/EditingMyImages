<?php

namespace App\Http\Request\Image\EditImages;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Images\EditImages\SetFilterCase;
use App\Arch\Domain\UserCase\Images\EditImages\ResizeImageCase;
use App\Http\Request\BaseRequest;

class ImageEditRequest extends BaseRequest{

    private ResizeImageCase $resizeImageCase;
    private SetFilterCase $setFilterCase;

    private const VALIDATE_RESIZE_IMAGE = [
        'id' => 'required|numeric',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
    ];

    private const VALIDATE_SET_FILTER = [
        'id' => 'required|numeric',
        'filter' => 'required|int|in:2,3,4,5',
        'red' => 'sometimes|required_if:filter,2|required_without_all:green,blue|int|min:1',
        'green' => 'sometimes|required_if:filter,2|required_without_all:red,blue|int|min:1',
        'blue' => 'sometimes|required_if:filter,2|required_without_all:red,green|int|min:1',
        'pixel_level' => 'int|required_if:filter,5|min:1',
    ];

    public function __construct(ResizeImageCase $resizeImageCase, SetFilterCase $setFilterCase){
        parent::__construct();
        $this -> resizeImageCase = $resizeImageCase;
        $this -> setFilterCase = $setFilterCase;
    }

    public function resizeImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_RESIZE_IMAGE);
        $this -> resizeImageCase -> setRequest($this -> getRequest());
        return $this -> resizeImageCase -> apply() -> getResponse();
    }

    public function setFilter(): BaseResponse{
        $this -> applyRules(self::VALIDATE_SET_FILTER);
        $this -> setFilterCase -> setRequest($this -> getRequest());
        return $this -> setFilterCase -> apply() -> getResponse();
    }
}
