<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\ClinicRepositoryInterface;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Model;

class ClinicRepository implements ClinicRepositoryInterface
{
    public function findAll($options = [])
    {
        $clinic = new Clinic();

        $clinic = $clinic->orderBy('id', 'desc')->get();
        return $clinic;
    }

    public function findById($id)
    {
        return Clinic::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $clinic = Clinic::create($params);
//            $this->syncRolesAndPermissions($params, $clinic);

            return $clinic;
        });
    }

    public function update($id, $params = [])
    {
        $clinic = Campaign::findOrFail($id);

        return DB::transaction(function () use ($params, $clinic) {
            $clinic->update($params);

            return $clinic;
        });
    }

    public function delete($id)
    {
        $role  = Campaign::findOrFail($id);

        return $role->delete();
    }

    public function getBrandNameById($id)
    {
        $brand = new Clinic();
        $brand = $brand->Where('id', '=', "$id");
        return $brand->get();
    }

}
