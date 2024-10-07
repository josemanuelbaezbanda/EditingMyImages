<?php

namespace App\Arch\Constants;

class AppConstant {

    public const PATH_TO_IMAGES = "images/";
    public const PATH_TO_FONT = "font\arial_narrow.ttf";
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
    public const SET_TEXT_CODE= 9;
    public const NO_SPECS_MODIFICATIONS = ["No specifications"];
}
