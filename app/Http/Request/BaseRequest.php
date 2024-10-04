<?php

namespace App\Http\Request;

use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\Response\BaseResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;

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

        if($validator -> fails()) {
            throw new ValidationException($validator, MessageConstant::BAD_DATA_REQUEST);
        };
    }

}

