<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\FileAttachmentsRepositoryInterface;

use App\Models\FileAttachments;
use Illuminate\Database\Eloquent\Model;

class FileAttachmentsRepository implements FileAttachmentsRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $user_id = $options['user_id'] ?? [];
        $clinic_id = $options['clinic_id'] ?? [];

        $fileAttachments = new FileAttachments();

        if ($user_id) {
            $fileAttachments = $fileAttachments
                ->where('user_id', $user_id);
        }

        if ($clinic_id) {
            $fileAttachments = $fileAttachments
                ->where('clinic_id', $clinic_id);
        }

        $fileAttachments = $fileAttachments->get();

        return $fileAttachments;
    }

    public function findAllByAssetId($asset_id)
    {
        $fileAttachments = new FileAttachments();
        return $fileAttachments->where('asset_id', $asset_id)->orderBy('attachment_id', 'desc')->get();
    }

    public function findById($id)
    {
        return FileAttachments::findOrFail($id);
    }

    public function get_clinic_img_by_clinic_id($id)
    {
        $fileAttachments = new FileAttachments();
        return $fileAttachments->where('clinic_id', $id)->first();
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $fileAttachments = FileAttachments::create($params);
            $this->syncRolesAndPermissions($params, $fileAttachments);

            return $fileAttachments;
        });
    }

    public function update($id, $params = [])
    {
        $fileAttachments = FileAttachments::findOrFail($id);

        return DB::transaction(function () use ($params, $fileAttachments) {
            $fileAttachments->update($params);

            return $fileAttachments;
        });
    }

    public function delete($id)
    {
        $fileAttachments  = FileAttachments::findOrFail($id);

        return $fileAttachments->delete();
    }
}
