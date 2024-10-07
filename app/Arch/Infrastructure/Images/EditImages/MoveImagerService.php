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

class MoveImagerService extends BaseService{
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
            $rotation = Arr::get($data, 'rotation');

            $modifiedImage = $this->moveImage($oldPath, $editType, $rotation);
            $newName = $this -> getNewName($image -> path .'/'. $image -> name);

            $modifiers = $this -> setModifiers(Arr::get($data, 'editType'), $rotation);

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

    public function moveImage (string $path, int $filterType, int $rotation = 0){
        $image = new ImageManager(new Driver());
        $image = $image -> read (str_replace('/', '\\',$path));

        return match($filterType){
            AppConstant::MIRROR_MOVE_HORIZONTAL_CODE => $image -> flop(),
            AppConstant::MIRROR_MOVE_VERTICAL_CODE => $image -> flip(),
            AppConstant::ROTATE_IMAGE_CODE => $image -> rotate($rotation),
        };
    }

}
