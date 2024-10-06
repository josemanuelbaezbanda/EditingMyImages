<?php

namespace App\Arch\Infrastructure\Images;

use App\Arch\Infrastructure\BaseService;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetImagesService extends BaseService{

    public function execute()
    {
        $data = $this -> iterator -> transform();
        try {

            $image = Image::where('id', Arr::get($data, 'id'))
                ->where('active', true)
                ->select(['id','name','path','modifications'])
                ->first();

            if(!isset($image)){
                throw  new NotFoundHttpException();
            }

            $this -> iterator ->feedback($image);
        } catch(\Exception $exception) {
            $this -> iterator -> feedback(false);
        }
    }

}
