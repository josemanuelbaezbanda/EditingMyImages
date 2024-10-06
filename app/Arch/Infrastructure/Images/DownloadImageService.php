<?php

namespace App\Arch\Infrastructure\Images;

use App\Arch\Infrastructure\BaseService;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DownloadImageService extends BaseService{

    public function execute()
    {
        $data = $this -> iterator -> transform();
        try {
            DB::beginTransaction();

            $image = Image::where('id', Arr::get($data, 'id'))
                ->where('active', true)
                ->select(['id','name','path'])
                ->first();

            $this -> iterator ->feedback($image);

            DB::commit();

        } catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

}
