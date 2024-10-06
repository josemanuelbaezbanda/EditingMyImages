<?php

namespace App\Arch\Infrastructure\Images\EditImages;

use App\Arch\Infrastructure\BaseService;
use App\Arch\Infrastructure\ImageHelper;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Intervention\Image\Facades\Image as InterventionImage;

class ResizeImagesService extends BaseService{
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
            $width = Arr::get($data, 'width');
            $height = Arr::get($data, 'height');

            $modifiedImage = $this->resize($oldPath, $width, $height);
            $newName = $this -> getNewName($image -> path .'/'. $image -> name );
            $modifiers = $this -> setModifiers(Arr::get($data, 'editType'), $width, $height);

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

    public function resize (string $path, int $width, int $height){
        $image = InterventionImage::make(str_replace('/', '\\',$path));

        $image -> resize($width, $height);

        return $image;
    }

}
