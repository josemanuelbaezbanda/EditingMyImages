<?php

namespace App\Arch\Domain\UserCase\Images;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\ShowImagesService;
use Illuminate\Support\Arr;

class ShowImagesCase extends BaseUserCase implements BaseInterface {

    private ShowImagesService $getAllImagesService;

    public function __construct() {
        parent::__construct();
        $this -> getAllImagesService = new ShowImagesService($this);
    }
    public function transform(): array
    {
        return [
            'user_id' => $this -> getUser() -> getAuthIdentifier()
        ];
    }

    public function feedback(mixed $response)
    {
        $finalResponse = collect($response) -> map(function ($image) {
            return [
                'id' => Arr::get($image, 'id'),
                'name' => Arr::get($image, 'name'),
                'modified' => !(Arr::get($image,'modifications') == AppConstant::NULL_VALUE)
            ];
        });
        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $finalResponse);
    }

    public function apply(): BaseUserCase
    {
        $this -> getAllImagesService -> execute();
        return $this;
    }
}
