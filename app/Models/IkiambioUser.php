<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IkiambioUser extends Model
{
    protected $table = 'ikiambio_users';
    protected $primaryKey = 'id';

    // Usaremos createdDate / modifiedDate como timestamps de Laravel
    public $timestamps = true;
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'modifiedDate';

    protected $fillable = [
        'utplId','firstName','lastName','identification','username'
    ];

    protected $casts = [
        'createdDate' => 'datetime',
        'modifiedDate' => 'datetime',
        'lastLogin'   => 'datetime',
    ];

    // Accesor para nombre completo
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim(($this->firstName ?? '').' '.($this->lastName ?? ''));
    }
}