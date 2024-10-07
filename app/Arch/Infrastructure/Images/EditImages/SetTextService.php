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
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetTextService extends BaseService{
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
            $text = Arr::get($data, 'text');
            $xLocation = Arr::get($data, 'xLocation');
            $yLocation = Arr::get($data, 'yLocation');
            $size = Arr::get($data, 'size');
            $color = Arr::get($data, 'color');
            $stroke = Arr::get($data, 'stroke');
            $lineHeight = Arr::get($data, 'lineHeight');

            $modifiedImage = $this -> setText($oldPath, $text, $size, $color, $stroke, $lineHeight, $xLocation, $yLocation);
            $newName = $this -> getNewName($image -> path .'/'. $image -> name);
            $specsModifiers = $this ->setModifiersText($text, $size, $color, $stroke, $lineHeight, $xLocation, $yLocation);
            $modifiers = $this ->setModifiers($editType, $specsModifiers);

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
     * Función para agregar texto a una imagen
     * @param string $path URL de la imagen a modificar
     * @param string $text Texto que se agregara
     * @param int $size Tamaño de la fuente de la letra
     * @param string $color Color de la fuente de letra
     * @param string $stroke Color del contorno de la letra
     * @param int $lineHeight Tamaño del contorno de la letra
     * @param int $xLocation Localizción en X del texto
     * @param int $yLocation Localización en Y del texto
     * @return ImageInterface
     */
    public function setText(string $path, string $text, int $size, string $color, string $stroke, int $lineHeight, int $xLocation, int $yLocation){
        $image = new ImageManager(new Driver());
        $image = $image -> read (str_replace('/', '\\',$path));

        return $image -> text($text, $xLocation, $yLocation, function (FontFactory $font) use ($size, $color, $stroke, $lineHeight) {
            $font -> filename(AppConstant::PATH_TO_FONT);
            $font -> size($size);
            $font -> color($color);
            if (!$stroke == AppConstant::ZERO_VALUE) $font -> stroke($stroke);
            if (!$lineHeight == AppConstant::ZERO_VALUE) $font -> lineHeight($lineHeight);
        });
    }

}
