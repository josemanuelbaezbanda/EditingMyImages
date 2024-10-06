<?php

namespace App\Arch\Domain\UserCase\Images;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Auth\LoginService;
use App\Arch\Infrastructure\Images\StoreImageService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class StoreImageCase extends BaseUserCase implements BaseInterface {

    private StoreImageService $storeImageService;

    public function __construct() {
        parent::__construct();
        $this -> storeImageService = new StoreImageService($this);
    }
    public function transform(): array
    {
        $file = Arr::get($this ->getAttributes(), 'image');
        $filename = time() . '-' . $file -> getClientOriginalName();
        $path =AppConstant::PATH_TO_IMAGES. $this -> getUser() -> name . $this -> getUser() -> getAuthIdentifier();

        return [
            'file' => $file,
            'filename' => $filename,
            'name' => $filename,
            'path' => str_replace(' ', '',$path),
            'user_id' => $this ->getUser() -> getAuthIdentifier(),
            'modifications' => AppConstant::NULL_VALUE,
            'created_by' => $this -> getUser() -> getAuthIdentifier()
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $response);
    }

    public function apply(): BaseUserCase
    {
        $this -> storeImageService -> execute();
        return $this;
    }
}
