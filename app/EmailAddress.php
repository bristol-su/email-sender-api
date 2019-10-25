<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAddress extends Model
{
    protected $table = 'email_addresses';

    public function users()
    {
        return $this->belongsToMany(User::class, 'email_addresses_users');
    }
}
