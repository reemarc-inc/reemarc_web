<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\ScheduleRepositoryInterface;
use DB;


use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function findAll($options = [])
    {
        $schdule = new schdule();

        if (!empty($options['filter']['bejour'])) {
            $schdule = $schdule->whereNotIn('campaign_name', ['Bejour']);
        }

        $schdule = $schdule->orderBy('seq', 'asc')->get();

        return $schdule;
    }

    public function findById($id)
    {
        return schdule::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignBrand = schdule::create($params);
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

    public function getBrandNameById($id)
    {
        $brand = new schdule();
        $brand = $brand->Where('id', '=', "$id");
        return $brand->get();
    }

}
