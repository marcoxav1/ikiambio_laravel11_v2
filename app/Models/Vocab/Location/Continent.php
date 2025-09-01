<?php

namespace App\Models\Vocab\Location;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    protected $table = 'vocab_location_continent';
    protected $primaryKey = 'continent_id'; 
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['continent_value', 'description'];
}
