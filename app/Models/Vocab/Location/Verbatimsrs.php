<?php

namespace App\Models\Vocab\Location;

use Illuminate\Database\Eloquent\Model;

class Verbatimsrs extends Model
{
    protected $table = 'vocab_location_verbatimSRS';
    protected $primaryKey = 'verbatimSRS_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['verbatimSRS_value', 'description'];
}
