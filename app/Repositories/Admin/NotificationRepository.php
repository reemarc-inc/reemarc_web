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
        $notification = new Notification();
        $notification =$notification
            ->Select('type as notification_type',
                'id as id',
                'user_id as user_id',
                'appointment_id as appointment_id',
                'treatment_id as treatment_id',
                'clinic_id as clinic_id',
                'package_id as package_id',
                'is_read as is_read',
                'is_delete as is_delete',
                'note as note',
                'created_at as created_at'
            )
            ->Where('user_id', '=', $u_id)->Where('is_delete', '=', 'no')->orderBy('id','desc');
        return $notification->get();
    }

}
