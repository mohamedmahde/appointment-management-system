<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'last_seen',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => 'string',
            'last_seen' => 'datetime',
        ];
    }

    // علاقة المستخدم بالأدوار
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // علاقة المستخدم بالطلبات المرسلة
    public function sentRequests()
    {
        return $this->hasMany(\App\Models\Request::class, 'sender_id');
    }

    // علاقة المستخدم بالطلبات المستلمة
    public function receivedRequests()
    {
        return $this->hasMany(\App\Models\Request::class, 'receiver_id');
    }

    // علاقة المستخدم بالمستندات
    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class);
    }

    // علاقة المستخدم بالمواعيد كطالب
    public function requestedAppointments()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'requester_id');
    }

    // علاقة المستخدم بالمواعيد كمدير
    public function managedAppointments()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'manager_id');
    }

    // علاقة المستخدم بالرسائل المرسلة
    public function sentMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id');
    }

    // علاقة المستخدم بالرسائل المستلمة
    public function receivedMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'receiver_id');
    }
}
