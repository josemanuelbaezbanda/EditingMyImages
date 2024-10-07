<?php

namespace App\Http\Request\Image\EditImages;

use App\Arch\Domain\Response\BaseResponse;
use App\Arch\Domain\UserCase\Images\EditImages\MoveImageCase;
use App\Arch\Domain\UserCase\Images\EditImages\SetFilterCase;
use App\Arch\Domain\UserCase\Images\EditImages\ResizeImageCase;
use App\Arch\Domain\UserCase\Images\EditImages\SetTextCase;
use App\Http\Request\BaseRequest;

class ImageEditRequest extends BaseRequest{

    private ResizeImageCase $resizeImageCase;
    private SetFilterCase $setFilterCase;
    private MoveImageCase $moveImageCase;
    private SetTextCase $setTextCase;

    private const VALIDATE_RESIZE_IMAGE = [
        'id' => 'required|numeric',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
    ];
    private const VALIDATE_MOVE_IMAGE = [
        'id' => 'required|numeric',
        'filter' => 'required|int|in:6,7,8',
        'rotation' => 'int|required_if:filter,8|min:1|max:360',
    ];
    private const VALIDATE_SET_FILTER = [
        'id' => 'required|numeric',
        'filter' => 'required|int|in:2,3,4,5',
        'red' => 'sometimes|required_if:filter,2|required_without_all:green,blue|int|min:1',
        'green' => 'sometimes|required_if:filter,2|required_without_all:red,blue|int|min:1',
        'blue' => 'sometimes|required_if:filter,2|required_without_all:red,green|int|min:1',
        'pixel_level' => 'int|required_if:filter,5|min:1',
    ];

    private const VALIDATE_SET_TEXT = [
        'id' => 'required|numeric',
        'text' => 'required|string',
        'x_location' => 'required|numeric|min:1',
        'y_location' => 'required|numeric|min:1',
        'size' => 'required|numeric|min:1',
        'color' => 'required|string',
        'line_height' => 'nullable|numeric|min:1',
        'stroke' => 'nullable|string',
    ];

    public function __construct(ResizeImageCase $resizeImageCase, SetFilterCase $setFilterCase, MoveImageCase $moveImageCase, SetTextCase $setTextCase){
        parent::__construct();
        $this -> resizeImageCase = $resizeImageCase;
        $this -> setFilterCase = $setFilterCase;
        $this -> moveImageCase = $moveImageCase;
        $this -> setTextCase = $setTextCase;
    }

    /**
     * Ir al caso de uso para modificar el tamaño de una imagen
     * @return BaseResponse
     */
    public function resizeImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_RESIZE_IMAGE);
        $this -> resizeImageCase -> setRequest($this -> getRequest());
        return $this -> resizeImageCase -> apply() -> getResponse();
    }

    /**
     * Ir al caso de uso para agregar un filtro a una imagen
     * @return BaseResponse
     */
    public function setFilter(): BaseResponse{
        $this -> applyRules(self::VALIDATE_SET_FILTER);
        $this -> setFilterCase -> setRequest($this -> getRequest());
        return $this -> setFilterCase -> apply() -> getResponse();
    }

    /**
     * Ir al caso de uso para mover la imagen
     * @return BaseResponse
     */
    public function moveImage(): BaseResponse{
        $this -> applyRules(self::VALIDATE_MOVE_IMAGE);
        $this -> moveImageCase -> setRequest($this -> getRequest());
        return $this -> moveImageCase -> apply() -> getResponse();
    }

    /**
     * Ir al caso de uso para agregar texto de imagenes
     * @return BaseResponse
     */
    public function setText(): BaseResponse{
        $this -> applyRules(self::VALIDATE_SET_TEXT);
        $this -> setTextCase -> setRequest($this -> getRequest());
        return $this -> setTextCase -> apply() -> getResponse();
    }
}
