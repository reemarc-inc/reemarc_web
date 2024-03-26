<?php

namespace App\Repositories\Admin;

use App\Models\Treatments;
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

    public function get_patients_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from appointments
                where booked_start is not null
                  ' . $clinic_filter . '
                  and status in ("upcoming")
                order by status desc, booked_start desc');
    }
    public function get_follow_up_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from appointments
                where booked_start is not null
                  ' . $clinic_filter . '
                  and status in ("upcoming")
                order by status desc, booked_start desc');
    }

    public function get_package_ready_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and t.clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select u.first_name as user_first_name,
                    u.last_name as user_last_name,
                    t.user_id as user_id,
                    t.clinic_id as clinic_id,
                    c.name as clinic_name,
                    c.region as region,
                    t.appointment_id as appointment_id,
                    t.id as treatment_id,
                    t.status as treatment_status,
                    p.name as package_name,
                    p.number_of_aligners as number_of_aligners,
                    p.treatment_duration as treatment_duration
                from treatments t
                left join users u on u.id = t.user_id
                left join clinic c on c.id = t.clinic_id
                left join package p on p.id = t.package_id
                where t.status = "package_ready"
                  ' . $clinic_filter . '
                order by t.created_at desc');
    }

    public function get_package_ordered_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and t.clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select u.first_name as user_first_name,
                    u.last_name as user_last_name,
                    t.user_id as user_id,
                    t.clinic_id as clinic_id,
                    c.region as region,
                    c.name as clinic_name,
                    t.appointment_id as appointment_id,
                    t.id as treatment_id,
                    t.status as treatment_status,
                    p.name as package_name,
                    p.number_of_aligners as number_of_aligners,
                    p.treatment_duration as treatment_duration
                from treatments t
                left join users u on u.id = t.user_id
                left join clinic c on c.id = t.clinic_id
                left join package p on p.id = t.package_id
                where t.status = "package_ordered"
                  ' . $clinic_filter . '
                order by t.created_at desc');
    }

    public function get_visit_confirm_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from appointments
                where status in ("visit_confirming")
                  ' . $clinic_filter . '
                order by status desc, booked_start desc');
    }

    public function get_treatment_complete_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from appointments
                where status in ("treatment_completed")
                  ' . $clinic_filter . '
                order by status desc, booked_start desc');
    }

    public function get_user_pending_list_list_by_filter($clinic)
    {
        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from users
                where user_type in ("existing_member_pending")
                  ' . $clinic_filter . '
                order by id desc');
    }


    public function get_upcoming_appointments()
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', array("upcoming", "first_session_booked", "session_booked"));
        return $brand->get();
    }

    public function get_upcoming_appointments_by_clinic_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->WhereIn('status', array("upcoming","first_session_booked", "session_booked"))->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_complete_appointments_by_clinic_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->WhereIn('status', array("complete","session_completed"))->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_visit_confirming_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('user_id', '=', $c_id)
            ->WhereIn('status', array('visit_confirming'));
        return $brand->get();
    }

    public function get_upcoming_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('user_id', '=', $c_id)
            ->WhereIn('status', array('upcoming', 'first_session_booked', 'session_booked'));
        return $brand->get();
    }

    public function get_complete_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->WhereIn('status', array("complete", "session_completed"))
            ->Where('user_id', '=', $c_id)
            ->OrderBy('id', 'desc');
        return $brand->get();
    }

    public function get_cancel_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('status', '=', "cancel")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_total_appointments_by_user_id($c_id)
    {
        $brand = new Appointments();
        $brand = $brand->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_appointment_detail($c_id)
    {
        return DB::select('select clinic_id, booked_start, booked_end
                            from appointments
                            where clinic_id =:param_1
                            and status in ("upcoming", "first_session_booked", "session_booked")', [
                                'param_1' => $c_id
        ]);
    }

    public function check_double_book_a_day($user_id, $booked_date)
    {
        return DB::select('select *
                            from appointments
                           where user_id =:param_1
                             and status in ("upcoming", "first_session_booked", "session_booked")
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
                             and status in ("upcoming", "first_session_booked", "session_booked")
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
            ->Where('status', '=', 'cancel')
            ->first();
        return $aptmt_rs;
    }

    public function update_pending_appointment($clinic)
    {
        DB::update('update appointments set status = "Pending" where booked_date <=  DATE(NOW() - INTERVAL 1 DAY) and status in ("Upcoming")');

        if($clinic != '') {
            $clinic_filter = ' and clinic_id ="' . $clinic . '" ';
        }else{
            $clinic_filter = ' ';
        }

        return DB::select(
            'select *
                from appointments
                where booked_start is not null
                  and status in ("Pending", "Cancel")
                  ' . $clinic_filter . '
                order by status desc, booked_start asc');
    }

    public function get_current_session($treatment_id)
    {
        return DB::select('select *
                            from appointments
                            where treatment_id =:param_1
                            and status in ("first_session_booked", "session_booked", "session_completed", "visit_confirming")
                            order by id asc', [
            'param_1' => $treatment_id
        ]);
    }

    public function get_first_session($treatment_id)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('treatment_id', '=', $treatment_id)
            ->WhereIn('status', array('first_session_booked','session_completed','visit_confirming'))
            ->OrderBy('id', 'asc')
            ->first();

        return $aptmt_rs;
    }

    public function get_last_treatment_visit_confirming_appointment($treatment_id)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('treatment_id', '=', $treatment_id)
            ->WhereIn('status', array('visit_confirming'))
            ->OrderBy('id', 'desc')
            ->first();

        return $aptmt_rs;
    }

    public function get_last_treatment_upcoming_appointment($treatment_id)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('treatment_id', '=', $treatment_id)
            ->WhereIn('status', array('first_session_booked', 'session_booked'))
            ->OrderBy('id', 'desc')
            ->first();

        return $aptmt_rs;
    }

    public function get_last_treatment_session_status($treatment_id)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('treatment_id', '=', $treatment_id)
            ->WhereIn('status', array('first_session_booked', 'session_booked', 'visit_confirming', 'session_completed', 'cancel'))
            ->OrderBy('id', 'desc')
            ->first();

        return $aptmt_rs;
    }

    public function get_last_treatment_session($treatment_id)
    {
        $aptmt = new Appointments();
        $aptmt_rs = $aptmt->Where('treatment_id', '=', $treatment_id)
            ->WhereIn('status', array('visit_confirming'))
            ->OrderBy('id', 'desc')
            ->first();

        return $aptmt_rs;
    }

    public function check_session_exist($user_id)
    {
        $treatment = new Treatments();
        $treatment_rs = $treatment->Where('user_id', '=', $user_id)
            ->OrderBy('id', 'desc')
            ->first();
        return $treatment_rs;

    }

    public function get_recent_session($user_id)
    {
        $appointment = new Appointments();
        $appointment_rs = $appointment->Where('user_id', '=', $user_id)
            ->WhereIn('status', array('first_session_booked', 'session_booked', 'visit_confirming'))
            ->OrderBy('id', 'desc')
            ->first();
        return $appointment_rs;
    }

    public function get_recent_appointment($user_id)
    {
        $appointment = new Appointments();
        $appointment_rs = $appointment->Where('user_id', '=', $user_id)
            ->WhereIn('status', array('upcoming'))
            ->OrderBy('id', 'desc')
            ->first();
        return $appointment_rs;
    }

    public function check_first_session($user_id)
    {
        $appointment = new Appointments();
        $appointment_rs = $appointment->Where('user_id', '=', $user_id)
            ->WhereIn('status', array('session_completed'))
            ->OrderBy('id', 'desc')
            ->first();
        return $appointment_rs;
    }
}
