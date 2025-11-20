<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'description',
        'trainer',
        'start_date',
        'end_date',
        'location',
        'is_mandatory',
        'document_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_mandatory' => 'boolean',
    ];
}
