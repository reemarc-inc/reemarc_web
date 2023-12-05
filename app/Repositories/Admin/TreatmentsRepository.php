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

    public function findById($id)
    {
        return Treatments::findOrFail($id);
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

}
