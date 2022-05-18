<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionFiledAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'participant_event_id',
        'question_filed_id',
        'event_id',
        'participant_id',
        'answers',

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
