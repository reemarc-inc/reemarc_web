<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignAssetIndexRepositoryInterface;

use App\Models\CampaignAssetIndex;
use Illuminate\Database\Eloquent\Model;

class CampaignAssetIndexRepository implements CampaignAssetIndexRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignAssetIndex = new CampaignAssetIndex();

        if ($id) {
            $campaignAssetIndex = $campaignAssetIndex
                ->where('id', $id);
        }

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $campaignAssetIndex = $campaignAssetIndex->orderBy($field, $sort);
            }
        }

        if ($perPage) {
            return $campaignAssetIndex->paginate($perPage);
        }

        $campaignAssetIndex = $campaignAssetIndex->get();

        return $campaignAssetIndex;
    }

    public function findById($id)
    {
        return campaignAssetIndex::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignAssetIndex = campaignAssetIndex::create($params);
//            $this->syncRolesAndPermissions($params, $campaignBrand);

            return $campaignAssetIndex;
        });
    }

    public function update($id, $params = [])
    {
        $campaignAssetIndex = campaignAssetIndex::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignAssetIndex) {
            $campaignAssetIndex->update($params);

            return $campaignAssetIndex;
        });
    }

    public function delete($id)
    {
        $campaignAssetIndex  = campaignAssetIndex::findOrFail($id);

        return $campaignAssetIndex->delete();
    }

    public function deleteByCampaignId($c_id)
    {
        $campaignAssetIndex =  new campaignAssetIndex();
        $obj = $campaignAssetIndex->where('campaign_id', $c_id)->delete();
        return $obj;
    }

    public function get_assets_final_approval_by_campaing_id($c_id)
    {
        $campaignAssetIndex =  new campaignAssetIndex();
        $obj = $campaignAssetIndex->where('campaign_id', $c_id)->get();
        return $obj;
    }

    public function get_complete_assets_list($str, $asset_id, $campaign_id)
    {
        $filter_1 = !empty($str) ? ' and name like "%'.$str.'%" ' : '';
        $filter_2 = !empty($asset_id) ? ' and a_id ='.$asset_id : '';
        $filter_3 = !empty($campaign_id) ? ' and c_id ='.$campaign_id : '';

        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    ci.name as name,
                    cai.status
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            where cai.status = "copy_complete"
            ' . $filter_1 . $filter_2 . $filter_3 . '
            order by due asc');
    }

    public function get_asset_jira_todo($str)
    {
        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    ci.name as name,
                    cai.status,
                    cai.assignee,
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "to_do"
            and cai.assignee like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_progress($str)
    {
        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    ci.name as name,
                    cai.status,
                    cai.assignee,
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "in_progress"
            and cai.assignee like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_done($str)
    {
        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    ci.name as name,
                    cai.status,
                    cai.assignee,
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "done"
            and cai.assignee like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_finish($str)
    {
        return DB::select(
            'select  c_id as campaign_id,
                    a_id as asset_id,
                    a_type as asset_type,
                    due,
                    ci.name as name,
                    cai.status,
                    cai.assignee,
                    cb.campaign_name,
                    cai.updated_at
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "final_approval"
            and cai.assignee like "%'.$str.'%"
            and cai.updated_at >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)
            order by updated_at asc');
    }

    public function get_asset_jira_copy_request($str, $brand_id)
    {

        if($brand_id != '') {
            $brand_filter = ' and ci.campaign_brand =' . $brand_id . ' ';
        }else{
            $brand_filter = ' ';
        }

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
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join users u on u.id = ci.author_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "copy_requested"
            and ci.name is not null
              ' . $brand_filter . '
            and date_created > "2022-01-01 00:00:00"
            and u.first_name like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_copy_review($str, $brand_id)
    {
        if($brand_id != '') {
            $brand_filter = ' and ci.campaign_brand =' . $brand_id . ' ';
        }else{
            $brand_filter = ' ';
        }

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
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join users u on u.id = ci.author_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "copy_review"
            and ci.name is not null
              ' . $brand_filter . '
            and date_created > "2021-01-01 00:00:00"
            and u.first_name like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_copy_complete($str, $brand_id)
    {
        if($brand_id != '') {
            $brand_filter = ' and ci.campaign_brand =' . $brand_id . ' ';
        }else{
            $brand_filter = ' ';
        }

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
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join users u on u.id = ci.author_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "copy_complete"
            and ci.name is not null
              ' . $brand_filter . '
            and date_created > "2022-03-01 00:00:00"
            and u.first_name like "%'.$str.'%"
            order by due asc');
    }

    public function get_asset_jira_waiting_final_approval($str, $brand_id)
    {
        if($brand_id != '') {
            $brand_filter = ' and ci.campaign_brand =' . $brand_id . ' ';
        }else{
            $brand_filter = ' ';
        }

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
                    cb.campaign_name
            from
                    (select id as c_id, asset_id as a_id, type as a_type, email_blast_date as due from  campaign_type_email_blast
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
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_image_request
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_roll_over
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_store_front
                    union all
                    select id as c_id, asset_id as a_id, type as a_type, launch_date as due from campaign_type_a_content) b
            left join campaign_asset_index cai on cai.id = a_id
            left join campaign_item ci on ci.id = c_id
            left join users u on u.id = ci.author_id
            left join campaign_brands cb on cb.id = ci.campaign_brand
            where cai.status = "done"
            and ci.name is not null
              ' . $brand_filter . '
            and u.first_name like "%'.$str.'%"
            order by due asc');
    }

}
