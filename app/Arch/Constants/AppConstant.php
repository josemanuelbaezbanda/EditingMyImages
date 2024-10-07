<?php

namespace App\Arch\Constants;

use Symfony\Component\Mailer\EventListener\EnvelopeListener;

class AppConstant {

    public const PATH_TO_IMAGES = "images/";
    public const NOT_FOUND_VALUE = -1;
    public const ZERO_VALUE = 0;
    public const NULL_VALUE = null;

    public const RESIZE_CODE = 1;
    public const FILTER_RGB_CODE= 2;
    public const FILTER_NEGATIVE_CODE= 3;
    public const FILTER_BW_CODE= 4;
    public const FILTER_PIXELATION_CODE= 5;
    public const MIRROR_MOVE_HORIZONTAL_CODE= 6;
    public const MIRROR_MOVE_VERTICAL_CODE= 7;
    public const ROTATE_IMAGE_CODE= 8;
}
