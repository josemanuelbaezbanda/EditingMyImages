<?php

namespace App\Arch\Domain\UserCase\Images;

use App\Arch\Constants\AppConstant;
use App\Arch\Constants\MessageConstant;
use App\Arch\Domain\UserCase\BaseInterface;
use App\Arch\Domain\UserCase\BaseUserCase;
use App\Arch\Infrastructure\Images\GetImagesService;
use Illuminate\Support\Arr;

class GetImageCase extends BaseUserCase implements BaseInterface {

    private GetImagesService $getImagesService;

    public function __construct() {
        parent::__construct();
        $this -> getImagesService = new GetImagesService($this);
    }
    public function transform(): array
    {
        return [
            'id' => Arr::get($this -> getAttributes(),'id')
        ];
    }

    public function feedback(mixed $response)
    {
        if(!$response) {
            $this -> setResponse(MessageConstant::FAILED_REQUEST, AppConstant::NULL_VALUE);
            return;
        }

        $finalResponse = [
            'id' => Arr::get($response, 'id'),
            'name' => Arr::get($response, 'name'),
            'modifications' => json_decode(Arr::get($response, 'modifications')),
            'modified' => !(Arr::get($response,'modifications') == AppConstant::NULL_VALUE)
        ];

        $this -> setResponse(MessageConstant::SUCCESS_REQUEST, $finalResponse);
    }

    public function apply(): BaseUserCase
    {
        $this -> getImagesService -> execute();
        return $this;
    }
}
