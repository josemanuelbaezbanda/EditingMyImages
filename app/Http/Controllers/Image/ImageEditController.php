<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Request\Image\EditImages\ImageEditRequest;
use Illuminate\Http\Request;

class ImageEditController extends Controller
{
    private ImageEditRequest $request;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ImageEditRequest $imageEditRequest)
    {
        $this -> request = $imageEditRequest;
    }

    /**
     * Subir una imagen al servidor local
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resizeImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> resizeImage();
        return $this -> getResponse($response);
    }

    /**
     * Subir una imagen al servidor local
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setFilter(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> setFilter();
        return $this -> getResponse($response);
    }

    /**
     * Subir una imagen al servidor local
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function moveImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> moveImage();
        return $this -> getResponse($response);
    }

    /**
     * Subir una imagen al servidor local
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setText(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> setText();
        return $this -> getResponse($response);
    }

}
