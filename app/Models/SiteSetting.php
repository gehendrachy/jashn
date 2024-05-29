<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
    	'email', 'title', 'phone', 'mobile', 'mobile_viber', 'mobile_whatsapp', 'address', 'logo', 'favicon', 'facebookurl', 'twitterurl', 'instagramurl', 'googlemapurl', 'youtubeurl', 'how_to_order_link', 'aboutus', 'og_title', 'og_description', 'og_image', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    
}
