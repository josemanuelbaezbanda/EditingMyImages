<?php

namespace App\Arch\Infrastructure;

use App\Arch\Constants\AppConstant;

trait ImageHelper
{
    /** Devuelve el nuevo nombre de un archivo modificado
     * @param string $path Url del archivo
     * @return string
     */
    private function getNewName(string $path) : string {
        $filenameWithoutExtension = pathinfo($path, PATHINFO_FILENAME);
        $originName = explode('-', $filenameWithoutExtension)[0];
        return $originName . '-' . time() .'.'. pathinfo($path, PATHINFO_EXTENSION);
    }

    /** Regresa el nombre del filtro especifico
     * @param int $typeEdit Tipo de filtro
     * @return string
     */
    public function getEditValue (int $typeEdit) : string
    {
        return match($typeEdit) {
            AppConstant::RESIZE_CODE => "Resize",
            AppConstant::FILTER_RGB_CODE => "RGB Color Correction",
            AppConstant::FILTER_BW_CODE => "Greyscale Filter",
            AppConstant::FILTER_NEGATIVE_CODE => "Negative Filter",
            AppConstant::FILTER_PIXELATION_CODE => "Pixelation Filter",
            AppConstant::MIRROR_MOVE_HORIZONTAL_CODE => "Mirror Horizontal Move",
            AppConstant::MIRROR_MOVE_VERTICAL_CODE => "Mirror Vertical Move",
            AppConstant::ROTATE_IMAGE_CODE => "Rotation Image",
            AppConstant::SET_TEXT_CODE => "Set Text",
            default => AppConstant::NOT_FOUND_VALUE
        };
    }

    /** Crear array que guarda las modificaciones a una imagen
     * @param mixed $typeEdit Tipo de filtro
     * @param array|null $modifiers Array de las especificaciones de modificaciones
     * @return array
     */
    public function setModifiers (int $typeEdit, array $modifiers = null) : array{
        return [
            'Modifiers' => $this -> getEditValue($typeEdit),
            'Settings' => $modifiers
        ];
    }

    /** Crear array de las especificaciones de modificaciones de redimensionamiento
     * @param int $width Anchura de la nueva imagen
     * @param int $height Altura de la nueva imagen
     * @return array
     */
    public function setModifiersSize(int $width, int $height) : array{
        return[
            'width' => $width,
            'height' => $height
        ];
    }

    /** Crear array de las especificaciones de modificaciones de corrección de color RGB
     * @param int $red Corrección en rojos
     * @param int $green Corrección en verdes
     * @param int $blue Corrección en blues
     * @return array
     */
    public function setModifiersRGB(int $red, int $green, int $blue) : array{
        return[
            'red' => $red,
            'green' => $green,
            'blue' => $blue,
        ];
    }

    /**Crear array de las especificaciones de modificaciones de filtro de pixel
     * @param int $pixelationLevel Nivel de pixelación
     * @return array
     */
    public function setModifiersPixelation(int $pixelationLevel) : array{
        return[
            'level_of_pixelation' => $pixelationLevel
        ];
    }

    /** Crear array de las especificaciones de modificaciones de rotación
     * @param int $rotation Grados de rotación
     * @return array
     */
    public function setModifiersRotation(int $rotation) : array{
        return[
            'rotation' => $rotation
        ];
    }

    /** Crear array de las especificaciones de modificaciones al agregar texto
     * @param string $text Texto a agregar
     * @param int $size Tamaño del texto
     * @param string $color Color del texto
     * @param string $stroke Color del contorno
     * @param int $lineHeight Tamaño del contorno
     * @param int $xLocation Locación en X de la imagen para poner el texto
     * @param int $yLocation Locación en Y de la imagen para poner el texto
     * @return array
     */
    public function setModifiersText(string $text, int $size, string $color, string $stroke, int $lineHeight, int $xLocation, int $yLocation) : array{
        return[
            'text' => $text,
            'size' => $size,
            'color' => $color,
            'stroke' => $stroke,
            'line_height' => $lineHeight,
            'location_x' => $xLocation,
            'location_y' => $yLocation
        ];
    }

}
