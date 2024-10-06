<?php

namespace App\Arch\Domain\Response;

use Psy\Util\Str;

class BaseResponse {

    //Variable que almacena el path
    private string $path = '';
    //Variable para el mensaje que se envía al front
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

    /**Retorna el path de un archivo
     * @return string
     */
    public function getPath(): string {
        return $this->path;
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

    /** Crea la ruta de un archivo
     * @param string $path
     * @param string $filename
     * @return void
     */
    public function setPath(string $path, string $filename): void {
        $this -> path = str_replace('/', '\\', ($path . '/'. $filename));
    }

}
