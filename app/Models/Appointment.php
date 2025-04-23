<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title', 'requester_id', 'manager_id', 'status', 'appointment_time', 'rejection_reason'
    ];
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}


// تم حذف التكرار الخاطئ لتعريف الكلاس Appointment
