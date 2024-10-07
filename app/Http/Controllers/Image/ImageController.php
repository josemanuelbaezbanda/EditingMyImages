<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Request\Image\ImageRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    private ImageRequest $request;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ImageRequest $imageRequest)
    {
        $this -> request = $imageRequest;
    }

    /**
     * Subir una imagen al servidor local
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> storeImage();
        return $this -> getResponse($response);
    }

    /**
     * Traer el listado de imagenes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showImages() {
        $response = $this -> request -> showImages();
        return $this -> getResponse($response);
    }

    /**
     * Traer el imagen
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> getImage();
        return $this -> getResponse($response);
    }


    /**
     * Descargar la imagen
     * @param Request $args
     * @return BinaryFileResponse
     */
    public function downloadImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> downloadImage();
        return $this -> getDownloadResponse($response);
    }

}
