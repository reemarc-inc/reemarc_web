<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignAssetIndex extends Model
{
    use HasFactory;

    protected $table = 'campaign_asset_index';

    protected $fillable = [
        'id',
        'campaign_id',
        'author_id',
        'type',
        'team_to',
        'status',
        'assignee',
        'copy_writer',
        'decline_copy',
        'decline_creative',
        'decline_kec'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

}
