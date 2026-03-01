<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ["name", "description", "active", "system"];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_role',
            'role_id',
            'user_id',
        )->with([
            'role_id',
            'user_id'
        ]);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
