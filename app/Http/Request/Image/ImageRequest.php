<?php

namespace App\Http\Request\Image;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Images\DownloadImageCase;
use App\Arch\Domain\UserCase\Images\ShowImagesCase;
use App\Arch\Domain\UserCase\Images\GetImageCase;
use App\Arch\Domain\UserCase\Images\StoreImageCase;
use App\Http\Request\BaseRequest;

class ImageRequest extends BaseRequest{

    private StoreImageCase $storeImageCase;
    private ShowImagesCase $showImagesCase;
    private GetImageCase $getImageCase;
    private DownloadImageCase $downloadImageCase;

    private const VALIDATE_STORE_IMAGE = [
        'image' => 'required|file|mimes:jpeg,jpg,png|max:2048',
    ];
    private const VALIDATE_GET_IMAGE = [
        'id' => 'required|numeric',
    ];

    private const VALIDATE_DOWNLOAD_IMAGE = [
        'id' => 'required|numeric',
    ];

    public function __construct(StoreImageCase $storeImageCase, ShowImagesCase $showImagesCase, GetImageCase $getImageCase, DownloadImageCase $downloadImageCase){
        parent::__construct();
        $this -> storeImageCase = $storeImageCase;
        $this -> showImagesCase = $showImagesCase;
        $this -> getImageCase = $getImageCase;
        $this -> downloadImageCase = $downloadImageCase;
    }

    public function storeImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_STORE_IMAGE);
        $this -> storeImageCase -> setRequest($this -> getRequest());
        return $this -> storeImageCase -> apply() -> getResponse();
    }

    public function showImages(): BaseResponse{
        return $this -> showImagesCase -> apply() -> getResponse();
    }

    public function getImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_GET_IMAGE);
        $this -> getImageCase -> setRequest($this -> getRequest());
        return $this -> getImageCase -> apply() -> getResponse();
    }

    public function downloadImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_DOWNLOAD_IMAGE);
        $this -> downloadImageCase -> setRequest($this -> getRequest());
        return $this -> downloadImageCase -> apply() -> getResponse();
    }
}
