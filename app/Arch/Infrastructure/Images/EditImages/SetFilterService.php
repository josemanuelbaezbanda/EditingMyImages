<?php

namespace App\Arch\Infrastructure\Images\EditImages;

use App\Arch\Constants\AppConstant;
use App\Arch\Infrastructure\BaseService;
use App\Arch\Infrastructure\ImageHelper;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetFilterService extends BaseService{
    use ImageHelper;

    public function execute()
    {
        $data = $this -> iterator -> transform();
        try {
            DB::beginTransaction();
            $image = Image::where('id', Arr::get($data, 'id'))
                ->where('active', true)
                ->select(['id','name','path','modifications'])
                ->first();
            if(!isset($image)){
                throw  new NotFoundHttpException();
            }

            $oldPath = $image -> path .'/'. $image -> name;
            $editType = Arr::get($data, 'editType');
            $red = Arr::get($data, 'red');
            $green = Arr::get($data, 'green');
            $blue = Arr::get($data, 'blue');
            $pixelation = Arr::get($data, 'pixelation');

            $modifiedImage = $this->setFilter($oldPath, $editType, $red, $green, $blue, $pixelation);
            $newName = $this -> getNewName($image -> path .'/'. $image -> name);

            $modifiers = $this -> setModifiers(Arr::get($data, 'editType'), $red, $green, $blue, $pixelation);

            $response = Image::create([
                'name' => $newName,
                'path' => $image -> path,
                'user_id' => Arr::get($data, 'user_id'),
                'created_by' => Arr::get($data, 'user_id')
            ]);

            $response -> modifications = collect(json_decode($image -> modifications)) -> push($modifiers) -> toArray();
            $response -> save();

            $modifiedImage -> save($image -> path .'/'. $newName);

            DB::commit();

            $this -> iterator ->feedback($response);
        } catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function setFilter (string $path, int $filterType ,int $red , int $green , int $blue , int $pixelation){
        $image = new ImageManager(new Driver());
        $image = $image -> read (str_replace('/', '\\',$path));

        return match($filterType){
            AppConstant::FILTER_RGB_CODE => $image ->colorize($red, $green, $blue),
            AppConstant::FILTER_NEGATIVE_CODE => $image -> invert(),
            AppConstant::FILTER_BW_CODE => $image -> greyscale(),
            AppConstant::FILTER_PIXELATION_CODE => $image ->pixelate($pixelation),
            default => AppConstant::NOT_FOUND_VALUE
        };
    }

}
