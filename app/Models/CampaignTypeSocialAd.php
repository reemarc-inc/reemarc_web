<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeSocialAd extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_social_ad';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'date_from',
        'date_to',
        'include_formats',
        'dark_post',
        'pinterest_post',
        'pinterest_carousel',
        'igfb_stories',
        'igfb_post',
        'collection',
        'carousel',
        'ecommerce_post',
        'text',
        'headline',
        'newsfeed',
        'terms_and_conditions',
        'products_featured',
        'click_through_links',
        'utm_code',
        'promo_code',
        'final_preview_link',
        'date_created',
        'asset_id'
    ];

//    public function users()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';
//    public $incrementing = true;

}
