<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 1. Pencarian Nama Peminjam atau Buku
        $query->when($filters['search'] ?? null, function (Builder $q, string $search) {
            $q->where(function (Builder $sub) use ($search) {
                $sub->whereHas('member', function (Builder $m) use ($search) {
                    $m->where('name', 'like', "%{$search}%")
                    ->orWhere('member_code', 'like', "%{$search}%");
                })->orWhereHas('details.book', function (Builder $b) use ($search) {
                    $b->where('title', 'like', "%{$search}%");
                });
            });
        });

        // 2. Filter Status Peminjaman
        $query->when($filters['status'] ?? null, function (Builder $q, string $status) {
            if ($status === 'overdue') {
                // Status pinjam yang sudah melewati batas waktu pengembalian
                $q->where('status', 'borrowed')
                ->where('due_date', '<', now()->toDateString());
            } else {
                $q->where('status', $status);
            }
        });

        // 3. Filter Rentang Tanggal Pinjam
        $query->when($filters['start_date'] ?? null, function (Builder $q, string $start) {
            $q->whereDate('borrowed_date', '>=', $start);
        });

        $query->when($filters['end_date'] ?? null, function (Builder $q, string $end) {
            $q->whereDate('borrowed_date', '<=', $end);
        });

        // 4. Sorting Tanggal
        $sortBy = $filters['sort_by'] ?? 'latest';
        match ($sortBy) {
            'borrowed_asc' => $query->orderBy('borrowed_date', 'asc'),
            'due_asc'      => $query->orderBy('due_date', 'asc'),
            'due_desc'     => $query->orderBy('due_date', 'desc'),
            default        => $query->latest('borrowed_date'),
        };

        return $query;
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
