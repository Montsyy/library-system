<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
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
        // 1. Pencarian Nama Member atau Judul Buku
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

        // 2. Filter Status Peminjaman Dinamis
        $query->when($filters['status'] ?? null, function (Builder $q, string $status) {
            $today = Carbon::today();

            match ($status) {
                'returned'  => $q->where('status', 'returned'),
                'overdue'   => $q->where('status', 'borrowed')->whereDate('due_date', '<', $today),
                'due_today' => $q->where('status', 'borrowed')->whereDate('due_date', $today),
                'borrowed'  => $q->where('status', 'borrowed')->whereDate('due_date', '>', $today),
                default     => null,
            };
        });

        // 3. Filter Rentang Tanggal
        $query->when($filters['start_date'] ?? null, fn($q, $start) => $q->whereDate('borrowed_date', '>=', $start));
        $query->when($filters['end_date'] ?? null, fn($q, $end) => $q->whereDate('borrowed_date', '<=', $end));

        // 4. Urutan Cerdas (Smart Sorting)
        $sortBy = $filters['sort_by'] ?? 'urgent';
        match ($sortBy) {
            'borrowed_desc' => $query->latest('borrowed_date'),
            'borrowed_asc'  => $query->oldest('borrowed_date'),
            'due_asc'       => $query->orderBy('due_date', 'asc'),
            'due_desc'      => $query->orderBy('due_date', 'desc'),
            default         => $query
                // Prioritas: Tampilkan status 'borrowed' di atas 'returned'
                ->orderByRaw("CASE WHEN status = 'borrowed' THEN 0 ELSE 1 END")
                // Untuk yang masih dipinjam, dahulukan due_date terlama (yang terlambat paling lama di urutan paling atas)
                ->orderBy('due_date', 'asc')
                ->latest('borrowed_date'),
        };

        return $query;
    }
    
    public function getStatusBadgeAttribute(): array
    {
        // 1. Jika sudah dikembalikan
        if ($this->status === 'returned') {
            return [
                'label' => 'Dikembalikan',
                'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                'subtext' => $this->returned_date
                    ? 'Kembali: ' . Carbon::parse($this->returned_date)->format('d/m/Y')
                    : null,
            ];
        }

        // 2. Jika masih berstatus 'borrowed', cek tanggal jatuh tempo
        if ($this->due_date) {
            $dueDate = Carbon::parse($this->due_date);
            $today = Carbon::today();

            // Tanggal due_date sudah lewat dari hari ini
            if ($dueDate->lt($today) && ! $dueDate->isToday()) {
                $daysLate = (int) $dueDate->diffInDays($today);
                return [
                    'label' => 'Terlambat (' . $daysLate . ' hari)',
                    'class' => 'bg-red-100 text-red-700 border-red-200',
                    'subtext' => 'Batas: ' . $dueDate->format('d/m/Y'),
                ];
            }

            // Tepat hari ini adalah batas akhir pengembalian
            if ($dueDate->isToday()) {
                return [
                    'label' => 'Jatuh Tempo Hari Ini',
                    'class' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'subtext' => 'Batas hari ini',
                ];
            }
        }

        // 3. Masih dalam masa peminjaman aktif (belum jatuh tempo)
        return [
            'label' => 'Sedang Dipinjam',
            'class' => 'bg-blue-100 text-blue-700 border-blue-200',
            'subtext' => $this->due_date ? 'Batas: ' . Carbon::parse($this->due_date)->format('d/m/Y') : null,
        ];
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
