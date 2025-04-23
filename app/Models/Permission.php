<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    // علاقة الصلاحية بالأدوار
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
