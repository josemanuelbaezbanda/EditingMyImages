<?php

namespace App\Arch\Infrastructure\Images;

use App\Arch\Infrastructure\BaseService;
use App\Arch\Infrastructure\UserHelper;
use App\Models\Image;
use App\Models\User;
use Illuminate\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StoreImageService extends BaseService{
    use UserHelper;

    public function execute()
    {
        $data = $this -> iterator -> transform();
        try {
            DB::beginTransaction();
            $file = Arr::pull($data, 'file');
            $filename = Arr::pull($data, 'filename');

            $image = Image::firstOrCreate($data);
            $image -> created_by = Arr::get($data, 'created_by');
            $image -> save();

            $file -> move(Arr::get($data, 'path'), $filename);

            $this -> iterator ->feedback($image);

            DB::commit();

        } catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

}
