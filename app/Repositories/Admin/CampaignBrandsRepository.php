<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignBrandsRepositoryInterface;

use App\Models\CampaignBrands;

class CampaignBrandsRepository implements CampaignBrandsRepositoryInterface
{
    public function findAll($options = [])
    {
        $campaignBrands = new CampaignBrands();

        $campaignBrands = $campaignBrands->get();

        return $campaignBrands;
    }

    public function findById($id)
    {
        return CampaignBrands::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignBrand = CampaignBrands::create($params);
//            $this->syncRolesAndPermissions($params, $campaignBrand);

            return $campaignBrand;
        });
    }

    public function update($id, $params = [])
    {
        $campaignBrand = Campaign::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignBrand) {
            $campaignBrand->update($params);

            return $campaignBrand;
        });
    }

    public function delete($id)
    {
        $role  = Campaign::findOrFail($id);

        return $role->delete();
    }

}
