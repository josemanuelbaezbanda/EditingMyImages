<?php

namespace App\Arch\Infrastructure;

use App\Arch\Constants\AppConstant;

trait ImageHelper
{
    public const DEFAULT_MODIFICATIONS = ['Not Modifiers Apply'];
    private function getNewName(string $path) : string {
        $filenameWithoutExtension = pathinfo($path, PATHINFO_FILENAME);
        $originName = explode('-', $filenameWithoutExtension)[0];
        return $originName . '-' . time() .'.'. pathinfo($path, PATHINFO_EXTENSION);
    }

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
            default => AppConstant::NOT_FOUND_VALUE
        };
    }

    public function setModifiers (mixed $typeEdit, int $intValueX = AppConstant::NOT_FOUND_VALUE, $intValueY = AppConstant::NOT_FOUND_VALUE, $intValueZ = AppConstant::NOT_FOUND_VALUE, string $stringValue = null) : array{
        return [
            'Modifiers' => $this -> getEditValue($typeEdit),
            'Settings' => match ($typeEdit) {
                AppConstant::RESIZE_CODE => $this -> setModifiersSize($intValueX, $intValueY),
                AppConstant::FILTER_RGB_CODE => $this -> setModifiersRGB($intValueX, $intValueY, $intValueZ),
                AppConstant::FILTER_NEGATIVE_CODE, AppConstant::MIRROR_MOVE_HORIZONTAL_CODE, AppConstant::MIRROR_MOVE_VERTICAL_CODE, AppConstant::FILTER_BW_CODE => self::DEFAULT_MODIFICATIONS,
                AppConstant::FILTER_PIXELATION_CODE => $this -> setModifiersPixelation($intValueX),
                AppConstant::ROTATE_IMAGE_CODE => $this -> setModifiersRotation($intValueX),
            }
        ];
    }

    public function setModifiersSize(int $width, int $height) : array{
        return[
            'width' => $width,
            'height' => $height
        ];
    }

    public function setModifiersRGB(int $red, int $green, int $blue) : array{
        return[
            'red' => $red,
            'green' => $green,
            'blue' => $blue,
        ];
    }
    public function setModifiersPixelation(int $pixelationLevel) : array{
        return[
            'level_of_pixelation' => $pixelationLevel
        ];
    }

    public function setModifiersRotation(int $rotation) : array{
        return[
            'rotation' => $rotation
        ];
    }

}
