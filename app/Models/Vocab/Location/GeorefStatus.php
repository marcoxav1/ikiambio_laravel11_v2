<?php

namespace App\Models\Vocab\Location;

use Illuminate\Database\Eloquent\Model;

class GeorefStatus extends Model
{
    protected $table = 'vocab_location_georef_status';
    protected $primaryKey = 'georef_status_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['georef_status_value', 'description'];
}
