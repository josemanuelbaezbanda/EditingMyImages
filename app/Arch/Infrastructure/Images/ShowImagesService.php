<?php

namespace App\Arch\Infrastructure\Images;

use App\Arch\Infrastructure\BaseService;
use App\Arch\Infrastructure\UserHelper;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ShowImagesService extends BaseService{
    use UserHelper;

    public function execute()
    {
        $data = $this -> iterator -> transform();
        try {
            DB::beginTransaction();

            $imageList = Image::where('user_id', Arr::get($data, 'user_id'))
                ->where('active', true)
                ->select(['id','name','modifications','user_id'])
                ->get();

            $this -> iterator ->feedback($imageList);

            DB::commit();

        } catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

}
