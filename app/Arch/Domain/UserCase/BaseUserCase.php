<?php

namespace App\Arch\Domain\UserCase;

use App\Arch\Domain\Response\BaseResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

abstract class BaseUserCase {

    //Data que se recibe del Front
    private ?array $attributes;
    //La respuesta del Back
    private BaseResponse $response;

    public function __construct() {
        $this -> response = new BaseResponse();
    }

    /**
     * Guardar una request
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request) : BaseUserCase {
        $this -> attributes = $request -> all();
        return $this;
    }

    /**
     * Devolver los atributos
     * @return array|null
     */
    public function getAttributes(): ?array {
        return $this->attributes;
    }

    /**
     * Poner los mensajes y la data que se envia al front
     * @param string $message
     * @param mixed $data
     * @return void
     */
    public function setResponse(string $message, mixed $data) : void {
        $this -> response -> setMessage($message);
        $this -> response -> setData($data);
    }


    /**
     * Poner la respuesta de descarga
     * @param string $path
     * @param string $filename
     * @return void
     */
    public function setDownloadResponse(string $path, string $filename) : void {
        $this -> response ->setPath($path, $filename);
    }

    /**
     * Devolver respuesta
     * @return BaseResponse
     */
    public function getResponse() : BaseResponse {
        return $this -> response;
    }

    /**
     * Devolver usuario del token
     * @return Authenticatable|null
     */
    public function getUser() : Authenticatable {
        return auth()->user();
    }

    abstract public function apply() : BaseUserCase;


}

