<?php

namespace App\Repositories\Admin;

use App\Models\CampaignNotes;
use DB;

use App\Repositories\Admin\Interfaces\CampaignRepositoryInterface;

use App\Models\Campaign;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $campaigns = new Campaign();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $campaigns = $campaigns->orderBy($field, $sort);
            }
        }
        if (!empty($options['filter']['q'])) {
            $campaigns = $campaigns->Where('name', 'LIKE', "%{$options['filter']['q']}%");
        }
        if (!empty($options['filter']['status'])) {
            $campaigns = $campaigns->where('status', $options['filter']['status']);
        }
        if ($perPage) {
            return $campaigns->paginate($perPage);
        }

        $campaigns = $campaigns->get();

        return $campaigns;
    }

    public function findById($id)
    {
        return Campaign::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {

            $campaign = Campaign::create($params);

            return $campaign;
        });
    }

    public function update($id, $params = [])
    {
        $campaign = Campaign::findOrFail($id);

        return DB::transaction(function () use ($params, $campaign) {
            $campaign->update($params);

            return $campaign;
        });
    }

    public function delete($id)
    {
        $campaign  = Campaign::findOrFail($id);

        return $campaign->delete();
    }

    public function getAssetListById($id)
    {
        return DB::select('
            select  c_id, a_id, a_type,
            (select status from campaign_asset_index where id= a_id ) status,
                   (select assignee from campaign_asset_index where id= a_id) assignee,
                        (select decline_copy from campaign_asset_index where id= a_id) decline_copy,
                            (select decline_creative from campaign_asset_index where id= a_id) decline_creative,
                                (select decline_kec from campaign_asset_index where id= a_id) decline_kec,
                due from
                   (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from campaign_type_email_blast
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_landing_page
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_misc
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_search_ad
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_social_ad
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_video_production
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_website_banners
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_website_changes
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_topcategories_copy
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_programmatic_banners
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content
                    ) b where b.c_id=:id order by due desc', [
                    'id' => $id
        ]);
    }

    public function getAssetListByStatus($id)
    {
        return DB::select('select  c_id, a_id, a_type, (select status from campaign_asset_index where id= a_id ) status, due from
            (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from campaign_type_email_blast
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_landing_page
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_misc
            union all
            select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_search_ad
            union all
            select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_social_ad
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_video_production
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_website_banners
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_website_changes
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_topcategories_copy
            union all
            select id as c_id, asset_id as a_id, type as a_type, date_from as due from campaign_type_programmatic_banners
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_requst
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
            union all
            select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content
            ) b where b.c_id=:id order by due desc', [
            'id' => $id
        ]);
    }

    public function get_campaign_types()
    {
        return DB::select('select * from campaign_type');
    }

    public function get_asset_detail($a_id, $c_id, $a_type)
    {
        $table = 'campaign_type_' . $a_type;
        return DB::select('select * from '
            . $table .
            ' where id =:param_1
            and asset_id =:param_2', [
                'param_1' => $c_id,
                'param_2' => $a_id
        ]);
    }


    static function get_assets($id)
    {
        return DB::select('select type, email_blast_date as due from campaign_type_email_blast where id=:id1 union all
            select type, launch_date as due from campaign_type_landing_page where id=:id2 union all
            select type, launch_date from campaign_type_misc where id=:id3 union all
            select type, date_from from campaign_type_search_ad where id=:id4 union all
            select type, date_from from campaign_type_social_ad where id=:id5 union all
            select type, launch_date from campaign_type_video_production where id=:id6 union all
            select type, launch_date from campaign_type_website_banners where id=:id7 union all
            select type, launch_date from campaign_type_website_changes where id=:id8 union all
            select type, launch_date from campaign_type_topcategories_copy where id=:id9 union all
            select type, date_from from campaign_type_programmatic_banners where id=:id10 union all
            select type, launch_date from campaign_type_image_request where id=:id11 union all
            select type, launch_date from campaign_type_roll_over where id=:id12 union all
            select type, launch_date from campaign_type_store_front where id=:id13 union all
            select type, launch_date from campaign_type_a_content where id=:id14
            order by due desc', [
            'id1' => $id,
            'id2' => $id,
            'id3' => $id,
            'id4' => $id,
            'id5' => $id,
            'id6' => $id,
            'id7' => $id,
            'id8' => $id,
            'id9' => $id,
            'id10' => $id,
            'id11' => $id,
            'id12' => $id,
            'id13' => $id,
            'id14' => $id
        ]);
    }
}
