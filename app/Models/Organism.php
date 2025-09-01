<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organism extends Model
{
    protected $table = 'organism';
    protected $primaryKey = 'organismID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'organismID','associatedOccurrences','associatedOrganisms','previousIdentifications'
    ];

    // Para que el route model binding use organismID en /organism/{organism}
    public function getRouteKeyName()
    {
        return 'organismID';
    }
}