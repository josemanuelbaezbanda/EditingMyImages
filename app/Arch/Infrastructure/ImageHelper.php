<?php

namespace App\Arch\Infrastructure;

use App\Arch\Constants\AppConstant;

trait ImageHelper
{
    private function getNewName(string $path) : string {
        $filenameWithoutExtension = pathinfo($path, PATHINFO_FILENAME);
        $originName = explode('-', $filenameWithoutExtension)[0];
        return $originName . '-' . time() .'.'. pathinfo($path, PATHINFO_EXTENSION);
    }

    public function getEditValue (int $typeEdit) : string
    {
        return match($typeEdit) {
            AppConstant::RESIZE_CODE => "Resize",
            default => AppConstant::NOT_FOUND_VALUE
        };
    }

    public function setModifiers (int $typeEdit, int $width = AppConstant::NOT_FOUND_VALUE, $height = AppConstant::NOT_FOUND_VALUE) : array{
        return [
            'Modifiers' => $this -> getEditValue($typeEdit),
            'Settings' => match ($typeEdit) {
            AppConstant::RESIZE_CODE => $this -> setModifiersSize($width, $height),
            }
        ];
    }

    public function setModifiersSize (int $width, int $height) : array{
        return[
            'width' => $width,
            'height' => $height
        ];
    }

}
