<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\AppointmentsRepositoryInterface;
use DB;

use App\Models\Appointments;
use Illuminate\Database\Eloquent\Model;

class AppointmentsRepository implements AppointmentsRepositoryInterface
{
    public function findAll($options = [])
    {
        $appointments = new Appointments();

        $appointments = $appointments->orderBy('id', 'desc')->get();
        return $appointments;
    }

    public function findById($id)
    {
        return Appointments::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $appointments = Appointments::create($params);
//            $this->syncRolesAndPermissions($params, $appointments);

            return $appointments;
        });
    }

    public function update($id, $params = [])
    {
        $appointments = Appointments::findOrFail($id);

        return DB::transaction(function () use ($params, $appointments) {
            $appointments->update($params);

            return $appointments;
        });
    }

    public function delete($id)
    {
        $appointments  = Appointments::findOrFail($id);

        return $appointments->delete();
    }

    public function getBrandNameById($id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('id', '=', "$id");
        return $brand->get();
    }

}
