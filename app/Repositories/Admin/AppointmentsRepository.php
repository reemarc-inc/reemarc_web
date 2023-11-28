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

    public function get_upcoming_appointments()
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Upcoming");
        return $brand->get();
    }

    public function get_upcoming_appointments_by_clinic_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Upcoming")->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_complete_appointments_by_clinic_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Complete")->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_appointment_detail($c_id)
    {
        return DB::select('select clinic_id, booked_start, booked_end
                            from appointments
                            where clinic_id =:param_1
                            and status = "Upcoming"', [
                                'param_1' => $c_id
        ]);
    }

}
