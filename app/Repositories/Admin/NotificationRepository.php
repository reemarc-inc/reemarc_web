<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\NotificationRepositoryInterface;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function findAll($options = [])
    {
        $id = $options['id'] ?? [];
        $notification = new Notification();

        if ($id) {
            $notification = $notification
                ->where('treatment_id', $id);
        }

        $notification = $notification->orderBy('created_at', 'desc')->get();
        return $notification;
    }

    public function findById($id)
    {
        return Notification::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $notification = Notification::create($params);
//            $this->syncRolesAndPermissions($params, $notification);

            return $notification;
        });
    }

    public function update($id, $params = [])
    {
        $notification = Notification::findOrFail($id);

        return DB::transaction(function () use ($params, $notification) {
            $notification->update($params);

            return $notification;
        });
    }

    public function delete($id)
    {
        $notification  = Notification::findOrFail($id);

        return $notification->delete();
    }

    public function get_notification_list_by_user_id($u_id)
    {
//        $notification = new Notification();
//        $notification =$notification
//            ->Select('type as notification_type',
//                'id as id',
//                'user_id as user_id',
//                'appointment_id as appointment_id',
//                '(select status from appointments where id = appointment_id) as appointment_status',
//                'treatment_id as treatment_id',
//                'clinic_id as clinic_id',
//                'package_id as package_id',
//                'is_read as is_read',
//                'is_delete as is_delete',
//                'note as note',
//                'created_at as created_at'
//            )
//            ->Where('user_id', '=', $u_id)->Where('is_delete', '=', 'no')->orderBy('id','desc');
//        return $notification->get();

        $result = DB::select('
            select n.type as notification_type,
                n.id as id,
                n.user_id as user_id,
                n.appointment_id as appointment_id,
                a.status as appointment_status,
                (select status from treatments where appointment_id = a.id) as treatment_status,
                (select id from treatments where appointment_id = a.id) as treatment_id,
                n.clinic_id as clinic_id,
                n.is_read as is_read,
                n.is_delete as is_delete,
                n.note as note,
                n.created_at as created_at
            from notification n
            left join appointments a on a.id = n.appointment_id
            where n.user_id = :param_1
              and is_delete = "no"
              order by n.id desc', [
            'param_1' => $u_id
        ]);

        return $result;
    }

}
