<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'borrowed_date',
        'due_date',
        'returned_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_date' => 'date',
            'due_date' => 'date',
            'returned_date' => 'date',
        ];
    }

    public function getStatusAttribute($value)
    {
        return $value ?? 'borrowed';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function borrowingDetails()
    {
        return $this->details();
    }
}
