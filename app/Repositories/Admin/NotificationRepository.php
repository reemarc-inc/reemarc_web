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
        $notification = new Notification();

        $notification = $notification->orderBy('id', 'desc')->get();
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
        $notification =$notification->Where('user_id', '=', $u_id);
        return $notification->get();
    }

}
