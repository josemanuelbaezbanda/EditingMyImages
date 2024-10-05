<?php

namespace App\Http\Request\Image;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Images\StoreImageCase;
use App\Http\Request\BaseRequest;

class ImageRequest extends BaseRequest{

    private StoreImageCase $storeImageCase;

    private const VALIDATE_STORE_IMAGE = [
        'image' => 'required|file|mimes:jpeg,jpg,png|max:2048',
    ];

    public function __construct(StoreImageCase $storeImageCase){
        parent::__construct();
        $this -> storeImageCase = $storeImageCase;
    }

    public function storeImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_STORE_IMAGE);
        $this -> storeImageCase -> setRequest($this -> getRequest());
        return $this -> storeImageCase -> apply() -> getResponse();
    }
}
