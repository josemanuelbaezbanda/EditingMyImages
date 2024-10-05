<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Request\Auth\AuthRequest;
use App\Http\Request\Image\ImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * Logeo del usuario al sistema
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $args) {
        $this -> request -> setRequest($args);
        $response = $this -> request -> storeImage();
        return $this -> getResponse($response);
    }

}
