<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'type',
        'count_need_participate',
        'count_participated',
        'count_registered',
        'start_at',
        'end_at',
        'address',
        'description',
        'description_participant',
        'description_required',
        'images_str',
        'status',
        'is_active',
        'point_number',
        'id_manager_event',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
