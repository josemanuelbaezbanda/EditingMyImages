<?php

namespace App\Http\Request;

use App\Arch\Domain\Response\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

abstract class BaseRequest {

    //Data que se recibe del Front
    private ?Request $request;
    //La respuesta del Back
    private BaseResponse $response;

    public function __construct() {
        $this -> response = new BaseResponse();
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $newRequest) : BaseRequest {
        $this -> request = $newRequest;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array {
        return $this->request -> all();
    }

    public function getRequest() : Request {
        return $this -> request;
    }

    /**
     * @param string $message
     * @param mixed $data
     * @return void
     */
    public function setResponse(string $message, mixed $data) : void {
        $this -> response -> setMessage($message);
        $this -> response -> setData($data);
    }

    /**
     * @return BaseResponse
     */
    public function getResponse() : BaseResponse {
        return $this -> response;
    }

    public function applyRules(array $rules) {
        $validator = Validator::make($this -> getAttributes(), $rules);

        if ($validator -> fails()) {
            throw new HttpResponseException(response() -> json([
                'message' => 'Se ha producido un error al validar la request',
                'data' => $validator -> errors()
            ], Response::HTTP_BAD_REQUEST));
        }
    }

}

