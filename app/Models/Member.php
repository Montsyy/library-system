<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Member extends Model
{
    protected $fillable = [
        'member_code',
        'name',
        'email',
    ];

    public static function generateNextMemberCode(): string
    {
        $lastMember = self::orderByDesc('id')->first();

        if (! $lastMember || ! preg_match('/^(LS)(\d+)$/i', $lastMember->member_code, $matches)) {
            return 'LS001';
        }

        $nextNumber = (int) $matches[2] + 1;

        return 'LS' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Pencarian Kode Member, Nama, atau Email
        $query->when($filters['search'] ?? null, function (Builder $q, string $search) {
            $q->where(function (Builder $sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('member_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        });

        // Sorting Huruf dan Angka
        $sortBy = $filters['sort_by'] ?? 'latest';
        match ($sortBy) {
            'name_asc'         => $query->orderBy('name', 'asc'),        // Huruf: Nama A ke Z
            'name_desc'        => $query->orderBy('name', 'desc'),       // Huruf: Nama Z ke A
            'member_code_asc'  => $query->orderBy('member_code', 'asc'), // Kode: LS001 ke atas
            'member_code_desc' => $query->orderBy('member_code', 'desc'),
            'email_asc'        => $query->orderBy('email', 'asc'),
            default            => $query->latest('id'),
        };

        return $query;
    }

    public function borrowings() {
        return $this->hasMany(Borrowing::class);
    }
}
