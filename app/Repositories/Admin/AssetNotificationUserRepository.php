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

    public function getCopyWriterStatus()
    {
        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    date_created,
                    ci.name as name,
                    u.first_name as author_name,
                    cai.status,
                    cai.assignee,
                    cb.campaign_name,
                    cb.id as brand_id
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_landing_page
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_misc
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_social_ad
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_video_production
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_website_banners
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_topcategories_copy
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join users u on u.id = ci.author_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "copy_requested"
            and ci.name is not null
            and due > "2022-10-01 00:00:00"
            order by due asc');
    }

}
