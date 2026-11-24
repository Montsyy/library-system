<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'year',
        'stock',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    /**
     * Local scope untuk pencarian, filter, dan sorting buku
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 1. Pencarian Kata Kunci (Judul atau Penulis)
        $query->when($filters['search'] ?? null, function (Builder $q, string $search) {
            $q->where(function (Builder $sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        });

        // 2. Filter Kategori (Numerik: category_id)
        $query->when($filters['category_id'] ?? null, function (Builder $q, $categoryId) {
            $q->where('category_id', $categoryId);
        });

        // 3. Filter Ketersediaan Stok
        $query->when($filters['stock_status'] ?? null, function (Builder $q, string $status) {
            if ($status === 'available') {
                $q->where('stock', '>', 0);
            } elseif ($status === 'empty') {
                $q->where('stock', '<=', 0);
            }
        });

        // 4. Filter Rentang Tahun Terbit (Numerik)
        $query->when($filters['year'] ?? null, function (Builder $q, $year) {
            $q->where('year', $year);
        });

        // 5. Sorting (Huruf dan Angka)
        $sortBy = $filters['sort_by'] ?? 'latest';
        match ($sortBy) {
            'title_asc'  => $query->orderBy('title', 'asc'),   // Huruf: A ke Z
            'title_desc' => $query->orderBy('title', 'desc'),  // Huruf: Z ke A
            'author_asc' => $query->orderBy('author', 'asc'),  // Huruf: Penulis A ke Z
            'year_asc'   => $query->orderBy('year', 'asc'),    // Angka: Tahun terlama ke terbaru
            'year_desc'  => $query->orderBy('year', 'desc'),   // Angka: Tahun terbaru ke terlama
            'stock_asc'  => $query->orderBy('stock', 'asc'),   // Angka: Stok terendah
            'stock_desc' => $query->orderBy('stock', 'desc'),  // Angka: Stok terbanyak
            default      => $query->latest('id'),              // Default: Data input terbaru
        };

        return $query;
    }
}