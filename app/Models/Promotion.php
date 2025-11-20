<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'user_id',
        'current_rank',
        'new_rank',
        'effective_date',
        'document_number',
        'notes',
        'document_path',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
