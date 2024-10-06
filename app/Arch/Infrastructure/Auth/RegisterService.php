<?php

namespace App\Arch\Infrastructure\Auth;

use App\Arch\Infrastructure\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterService extends BaseService{

    public function execute()
    {
        try {
            DB::beginTransaction();
            $args = $this -> iterator ->transform();

            $user = User::firstOrCreate($args);

            $this -> iterator -> feedback($user -> toArray());
            DB::commit();
        } catch(\Exception $e) {
            Db::rollBack();

            throw new \Exception($e -> getMessage());
        }
    }

}
