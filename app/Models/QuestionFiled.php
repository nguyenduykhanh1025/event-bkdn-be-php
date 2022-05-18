<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionField extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'event_id',
        'type',
        'label',
        'description',
        'value',
        'answers_correct',

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
