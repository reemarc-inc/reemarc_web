<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\PackageRepositoryInterface;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;

class PackageRepository implements PackageRepositoryInterface
{
    public function findAll($options = [])
    {
        $package = new Package();

        $package = $package->orderBy('id', 'asc')->get();
        return $package;
    }

    public function findById($id)
    {
        return Package::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $package = Package::create($params);
//            $this->syncRolesAndPermissions($params, $Package);

            return $package;
        });
    }

    public function update($id, $params = [])
    {
        $package = Package::findOrFail($id);

        return DB::transaction(function () use ($params, $package) {
            $package->update($params);

            return $package;
        });
    }

    public function delete($id)
    {
        $package = Package::findOrFail($id);

        return $package->delete();
    }

}
