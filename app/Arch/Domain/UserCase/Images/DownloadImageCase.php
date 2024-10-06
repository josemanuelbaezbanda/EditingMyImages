<?php

namespace App\Arch\Domain\UserCase\Images;

use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\DownloadImageService;
use Illuminate\Support\Arr;

class DownloadImageCase extends BaseUserCase implements BaseInterface {

    private DownloadImageService $downloadImageService;

    public function __construct() {
        parent::__construct();
        $this -> downloadImageService = new DownloadImageService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(), "id"),
        ];
    }

    public function feedback(mixed $response)
    {
        $this -> setDownloadResponse(Arr::get($response, "path"), Arr::get($response, "name"));
    }

    public function apply(): BaseUserCase
    {
        $this -> downloadImageService -> execute();
        return $this;
    }
}
