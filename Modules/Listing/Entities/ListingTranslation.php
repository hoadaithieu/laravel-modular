<?php

namespace Modules\Listing\Entities;

use Illuminate\Database\Eloquent\Model;

class ListingTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
    protected $table = 'listing_translations';
}
