<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    //
    protected $fillable = ["titulo","username","tipo","password","url"];
    protected $casts = [
    'password' => 'encrypted', // O Laravel cuida do AES-256 automaticamente
];
}
