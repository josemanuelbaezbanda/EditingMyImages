<?php

namespace App\Arch\Domain\UserCase;

use App\Arch\Domain\Response\BaseResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Auth;

abstract class BaseUserCase {

    //Data que se recibe del Front
    private ?array $attributes;
    //La respuesta del Back
    private BaseResponse $response;

    public function __construct() {
        $this -> response = new BaseResponse();
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request) : BaseUserCase {
        $this -> attributes = $request -> all();
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array {
        return $this->attributes;
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

    /**
     * @return Authenticatable|null
     */
    public function getUser() : Authenticatable {
        return auth()->user();
    }

    abstract public function apply() : BaseUserCase;


}

