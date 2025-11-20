<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'issuer',
        'issued_at',
        'expired_at',
        'reference_number',
        'description',
        'document_path',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expired_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
