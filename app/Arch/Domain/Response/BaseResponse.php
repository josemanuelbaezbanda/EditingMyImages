<?php

namespace App\Arch\Domain\Response;

class BaseResponse {

    //Variable para el mensajer que se envía al front
    private string $message = 'Petición Exitosa';
    //Variable para almacenar la data que se envia como respuesta al front
    private mixed $data = [];

    public function __construct() {

    }

    /** Obtiene el mensaje que sera enviado al Front
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**Obtiene la data que sera enviada al Front
     * @return mixed
     */
    public function getData(): mixed {
        return $this->data;
    }

    /**Asigna la información que sera enviada como respuesta
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void {
        $this->data = $data;
    }

    /** Asigna un mensaje a la respuesta del back
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void {
        $this->message = $message;
    }

}
