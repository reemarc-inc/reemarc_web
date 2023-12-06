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
        if (!empty($options['filter']['status'])) {
            $appointments = $appointments->where('status', $options['filter']['status']);
        }
        if (!empty($options['filter']['region'])) {
            $appointments = $appointments->where('clinic_region', $options['filter']['region']);
        }
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

    public function get_patients_list_by_clinic_id($c_id)
    {
        $appointment = new Appointments();
        $appointment = $appointment->Where('status', '=', 'Upcoming');
        return $appointment->get();
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

    public function get_upcoming_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Upcoming")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_complete_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Complete")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_cancel_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "Cancel")->Where('user_id', '=', $c_id);
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

    public function check_double_book_a_day($user_id, $booked_date)
    {
        return DB::select('select *
                            from appointments
                           where user_id =:param_1
                             and status = "Upcoming"
                             and booked_date =:param_2', [
                                'param_1' => $user_id,
                                'param_2' => $booked_date
        ]);
    }

    public function check_taken_book($clinic_id, $booked_start)
    {
        return DB::select('select *
                            from appointments
                           where clinic_id =:param_1
                             and status = "Upcoming"
                             and booked_start =:param_2', [
            'param_1' => $clinic_id,
            'param_2' => $booked_start
        ]);
    }

    public function check_cancel_exist($user_id, $clinic_id, $booked_start)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('user_id', '=', $user_id)
            ->Where('clinic_id', '=', $clinic_id)
            ->Where('booked_start', '=', $booked_start)
            ->Where('status', '=', 'Cancel')
            ->first();
        return $aptmt_rs;
    }

}
