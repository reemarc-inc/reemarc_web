<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use DB;

use App\Repositories\Admin\Interfaces\UserRepositoryInterface;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

//use App\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $users = new User();
//        $users = (new User())->with('roles');

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $users = $users->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['team'])) {

            $users = $users->Where('team', 'LIKE', "%{$options['filter']['team']}%");
        }

        if (!empty($options['filter']['q'])) {
            $users = $users->Where('first_name', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('last_name', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('email', 'LIKE', "%{$options['filter']['q']}%");
        }

        if (!empty($options['filter']['role'])) {
            $users = $users->Where('role', 'LIKE', "%{$options['filter']['role']}%");
        }

        if ($perPage) {
            return $users->paginate($perPage);
        }

        return $users->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $user = User::create($params);
//            $this->syncRolesAndPermissions($params, $user);

            return $user;
        });
    }

    public function update($id, $params = [])
    {
        $user = User::findOrFail($id);

        if (!$params['password']) {
            unset($params['password']);
        }

        return DB::transaction(function () use ($params, $user) {

            $params['password'] = Hash::make($params['password']);
            $user->update($params);
//            $this->syncRolesAndPermissions($params, $user);

            return $user;
        });
    }

    public function delete($id)
    {
        $user  = User::findOrFail($id);

        return $user->delete();
    }

    public function findByBrandName($brand_name)
    {
        $users = new User();
        $users = $users->Where('user_brand', 'LIKE', "%$brand_name%");
        return $users->get();
    }

    public function getEmailByDesignerName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")->Where('role', '=', 'graphic designer');
        return $users->get();
    }

    public function getJoahDirector()
    {
        $users = new User();
        $users = $users->Where('role', '=', "creative director")->Where('user_brand', 'LIKE', "%JOAH Beauty%");
        return $users->get();
    }

    public function getCreativeDirector()
    {
        $users = new User();
        $users = $users->Where('role', '=', "creative director")->Where('user_brand', 'NOT LIKE', "%JOAH Beauty%");
        return $users->get();
    }

    public function getWriterByBrandName($brand_name)
    {
        $users = new User();
        $users = $users->Where('role', '=', "copywriter")->Where('user_brand', 'LIKE', "%$brand_name%");
        return $users->get();
    }

    public function getBrandsAssignedWriters()
    {
        return DB::select('
            select * from users where role ="copywriter" order by char_length(user_brand) desc
        ');
    }

    public static function getWritersNameByBrand($brand)
    {
        return DB::select('
            select * from users where role = "copywriter" and user_brand like "%'.$brand.'%"
        ');
    }


//    /**
//     * Sync roles and permissions
//     *
//     * @param Request $request
//     * @param $user
//     * @return string
//     */
//    private function syncRolesAndPermissions($params, $user)
//    {
//        // Get the submitted roles
//        $roles = isset($params['role_id']) ? [$params['role_id']] : [];
//        $permissions = isset($params['permissions']) ? $params['permissions'] : [];
//
//        // Get the roles
//        $roles = Role::find($roles);
//
//        // check for current role changes
//        if (!$user->hasAllRoles($roles)) {
//            // reset all direct permissions for user
//            $user->permissions()->sync([]);
//        } else {
//            // handle permissions
//            $user->syncPermissions($permissions);
//        }
//
//        $user->syncRoles($roles);
//
//        return $user;
//    }
}
