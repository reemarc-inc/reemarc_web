<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\AssetNotificationUserRepositoryInterface;

use App\Models\AssetNotificationUser;
use Illuminate\Database\Eloquent\Model;

class AssetNotificationUserRepository implements AssetNotificationUserRepositoryInterface
{
    public function findAll($options = [])
    {
        $assetNotificationUser = new AssetNotificationUser();

        $assetNotificationUser = $assetNotificationUser->get();

        return $assetNotificationUser;
    }

    public function findById($id)
    {
        return AssetNotificationUser::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $assetNotificationUser = AssetNotificationUser::create($params);

            return $assetNotificationUser;
        });
    }

    public function update($id, $params = [])
    {
        $assetNotificationUser = AssetNotificationUser::findOrFail($id);

        return DB::transaction(function () use ($params, $assetNotificationUser) {
            $assetNotificationUser->update($params);

            return $assetNotificationUser;
        });
    }

    public function delete($id)
    {
        $role  = AssetNotificationUser::findOrFail($id);

        return $role->delete();
    }

    public function getListByAssetId($a_id)
    {
        $assetNotificationUser = new AssetNotificationUser();
        $assetNotificationUser = $assetNotificationUser->Where('asset_id', '=', "$a_id");
        return $assetNotificationUser->get();
    }

    public function getByAssetId($a_id)
    {
        $assetNotificationUser = new AssetNotificationUser();
        $assetNotificationUser = $assetNotificationUser->Where('asset_id', '=', "$a_id");
        return $assetNotificationUser->get();
    }

}
