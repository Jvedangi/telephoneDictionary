<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'name',
        'phone_number',
        'alternate_number',
        'email',
        'company',
        'address',
        'notes',
        'favorite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(ContactGroup::class, 'group_id');
    }
}
