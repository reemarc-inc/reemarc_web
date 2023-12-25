<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\RecordRepositoryInterface;

use App\Models\Record;

class RecordRepository implements RecordRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $record = new Record();

        if ($id) {
            $record = $record
                ->where('treatment_id', $id);
        }

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $record = $record->orderBy($field, $sort);
            }
        }

        if ($perPage) {
            return $record->paginate($perPage);
        }

        $record = $record->get();

        return $record;
    }

    public function findById($id)
    {
        return record::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $record = record::create($params);
//            $this->syncRolesAndPermissions($params, $campaignBrand);

            return $record;
        });
    }

    public function update($id, $params = [])
    {
        $record = record::findOrFail($id);

        return DB::transaction(function () use ($params, $record) {
            $record->update($params);

            return $record;
        });
    }

    public function delete($id)
    {
        $record  = record::findOrFail($id);

        return $record->delete();
    }
}
