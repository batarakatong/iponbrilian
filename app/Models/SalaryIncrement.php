<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryIncrement extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'effective_date',
        'reason',
        'approved_by',
        'document_path',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
