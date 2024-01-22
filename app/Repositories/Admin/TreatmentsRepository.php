<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\TreatmentsRepositoryInterface;
use DB;

use App\Models\Treatments;
use Illuminate\Database\Eloquent\Model;

class TreatmentsRepository implements TreatmentsRepositoryInterface
{
    public function findAll($options = [])
    {
        $treatments = new Treatments();

        $treatments = $treatments->orderBy('id', 'desc')->get();
        return $treatments;
    }

    public function get_treatment_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            ' select
                    a.id as appointment_id,
                    a.user_first_name as first_name,
                    a.user_email as email,
                    a.booked_start as booked_start,
                    a.status as appointment_status,
                    a.treatment_id as treatment_id,
                    t.package_id as package_id,
                    t.session as session,
                    t.clinic_id as clinic_id,
                    a.created_at as created_at
                 from appointments a
                 left join treatments t on t.id = a.treatment_id
                 where a.status = "Treatment_Upcoming"
                  ' . $region_filter . '
                order by a.booked_start asc');
    }

    public function findById($id)
    {
        return Treatments::findOrFail($id);
    }

    public function get_package_by_treatment_id($treatment_id)
    {
        $result = DB::select('select p.id as package_id,
                                p.name as name,
                                p.number_of_aligners as number_of_aligners,
                                p.us_price as us_price,
                                p.kr_price as kr_price,
                                p.summary as summary,
                                t.session as session,
                                t.month as month
                        from treatments t
                        left join package p on p.id = t.package_id
                        where t.id = :param_1', [
            'param_1' => $treatment_id
        ]);

        return $result;
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $treatments = Treatments::create($params);
//            $this->syncRolesAndPermissions($params, $treatments);

            return $treatments;
        });
    }

    public function update($id, $params = [])
    {
        $treatments = Treatments::findOrFail($id);

        return DB::transaction(function () use ($params, $treatments) {
            $treatments->update($params);

            return $treatments;
        });
    }

    public function delete($id)
    {
        $treatments  = Treatments::findOrFail($id);

        return $treatments->delete();
    }

    public function get_upcoming_treatments()
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Upcoming");
        return $brand->get();
    }

    public function get_upcoming_treatments_by_clinic_id($c_id)
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Upcoming")->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_complete_treatments_by_clinic_id($c_id)
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Complete")->Where('clinic_id', '=', $c_id);
        return $brand->get();
    }

    public function get_upcoming_treatments_by_user_id($c_id)
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Upcoming")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_complete_treatments_by_user_id($c_id)
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Complete")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_cancel_treatments_by_user_id($c_id)
    {
        $brand = new Treatments();
        $brand = $brand->Where('status', '=', "Cancel")->Where('user_id', '=', $c_id);
        return $brand->get();
    }

    public function get_appointment_detail($c_id)
    {
        return DB::select('select clinic_id, booked_start, booked_end
                            from treatments
                            where clinic_id =:param_1
                            and status = "Upcoming"', [
                                'param_1' => $c_id
        ]);
    }

    public function check_double_book_a_day($user_id, $booked_date)
    {
        return DB::select('select *
                            from treatments
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
                            from treatments
                           where clinic_id =:param_1
                             and status = "Upcoming"
                             and booked_start =:param_2', [
            'param_1' => $clinic_id,
            'param_2' => $booked_start
        ]);
    }

    public function check_cancel_exist($user_id, $clinic_id, $booked_start)
    {
        $aptmt = new Treatments();
        $aptmt_rs = $aptmt->Where('user_id', '=', $user_id)
            ->Where('clinic_id', '=', $clinic_id)
            ->Where('booked_start', '=', $booked_start)
            ->Where('status', '=', 'Cancel')
            ->first();
        return $aptmt_rs;
    }

    public function get_follow_up_complete_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "follow_up_completed"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_package_ready_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "package_ready"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_package_ordered_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "package_ordered"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_location_sent_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "location_sent"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_location_confirmed_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "location_confirmed"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_package_shipped_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "package_shipped"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_package_delivered_list($region)
    {
        if($region != '') {
            $region_filter = ' and a.clinic_region ="' . $region . '" ';
        }else{
            $region_filter = ' ';
        }

        return DB::select(
            'select t.id as treatment_id,
                    a.id as appointment_id,
                    a.user_id as user_id,
                    a.user_first_name as user_first_name,
                    a.user_last_name as user_last_name,
                    a.user_email as user_email,
                    a.clinic_id as clinic_id,
                    a.clinic_name as clinic_name,
                    a.clinic_phone as clinic_phone,
                    a.clinic_address as clinic_address,
                    a.clinic_region as clinic_region,
                    a.booked_date as booked_date,
                    a.booked_start as booked_start,
                    a.booked_end as booked_end,
                    a.booked_day as booked_day,
                    a.booked_time as booked_time,
                    a.status as status,
                    t.created_at as created_at
                from treatments t
                left join appointments a on a.id = t.appointment_id
                where t.status = "package_delivered"
                  ' . $region_filter . '
                order by booked_start asc');
    }

    public function get_treatment_upcoming_list()
    {

    }

    public function get_treatment_completed_list()
    {

    }

}
