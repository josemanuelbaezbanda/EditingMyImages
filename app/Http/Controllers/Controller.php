<?php

namespace App\Http\Controllers;

use App\Arch\Domain\Response\BaseResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getResponse(BaseResponse $response) {
        $statusCode = $response -> getData() == null ? Response::HTTP_ACCEPTED : Response::HTTP_OK;

        return response() -> json([
            'message' => $response -> getMessage(),
            'data' => $response -> getData(),
        ], $statusCode);
    }

}
