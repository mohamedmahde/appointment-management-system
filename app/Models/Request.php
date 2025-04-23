<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'title', 'description', 'interviewee_name', 'type', 'status', 'sender_id', 'receiver_id', 'scheduled_time', 'rejection_reason', 'file_path', 'file_name'
    ];
    protected $casts = [
        'scheduled_time' => 'datetime',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}


// تم حذف التكرار الخاطئ لتعريف الكلاس Request
