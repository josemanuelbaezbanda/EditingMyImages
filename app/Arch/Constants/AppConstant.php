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
}
