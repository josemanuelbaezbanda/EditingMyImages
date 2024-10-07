<?php

namespace App\Arch\Infrastructure\Images\EditImages;

use App\Arch\Infrastructure\BaseService;
use App\Arch\Infrastructure\ImageHelper;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Interfaces\ImageInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Intervention\Image\ImageManager as InterventionImage;

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
            $specsModifiers = $this -> setModifiersSize($width, $height);
            $modifiers = $this -> setModifiers(Arr::get($data, 'editType'), $specsModifiers);

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

    /**
     * Función para redimensionar la imagen
     * @param string $path URL de la imagen
     * @param int $width Anchura de la nueva imagen
     * @param int $height Altura de la nueva imagen
     * @return ImageInterface
     */
    public function resize (string $path, int $width, int $height){
        $image = new InterventionImage (new Driver());
        return $image -> read(str_replace('/', '\\',$path)) -> resize($width, $height);
    }

}
