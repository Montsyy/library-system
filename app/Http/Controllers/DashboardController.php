<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Metrik Utama Ringkasan
        $totalBooks = Book::count();
        $totalBookStock = Book::sum('stock');
        $totalMembers = Member::count();
        $totalBorrowedBooks = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        // Peminjaman berstatus aktif namun sudah lewat due date (overdue)
        $overdueCount = Borrowing::where('status', 'borrowed')
            ->whereDate('due_date', '<', $today)
            ->count();

        // Total transaksi peminjaman yang dicatat bulan ini
        $thisMonthBorrowings = Borrowing::whereMonth('borrowed_date', $today->month)
            ->whereYear('borrowed_date', $today->year)
            ->count();

        // 2. Data Grafik: Tren Peminjaman 7 Hari Terakhir
        $last7Days = collect();
        $borrowTrendLabels = [];
        $borrowTrendData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $borrowTrendLabels[] = $date->isoFormat('dddd, D MMM');

            $count = Borrowing::whereDate('borrowed_date', $dateString)->count();
            $borrowTrendData[] = $count;
        }

        // 3. Data Grafik: Distribusi Koleksi Buku per Kategori
        $categoryDistribution = Category::withCount('books')
            ->having('books_count', '>', 0)
            ->orderByDesc('books_count')
            ->take(6)
            ->get();

        $categoryLabels = $categoryDistribution->pluck('name')->toArray();
        $categoryData = $categoryDistribution->pluck('books_count')->toArray();

        // 4. Daftar 5 Buku Paling Sering Dipinjam
        $popularBooks = Book::select('books.id', 'books.title', 'books.author', 'books.stock', DB::raw('SUM(borrowing_details.quantity) as total_borrowed'))
            ->join('borrowing_details', 'books.id', '=', 'borrowing_details.book_id')
            ->groupBy('books.id', 'books.title', 'books.author', 'books.stock')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();

        // 5. Daftar Peminjaman Kritis (Terlambat atau Jatuh Tempo dalam 2 Hari ke Depan)
        $urgentBorrowings = Borrowing::with(['member', 'details.book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', '<=', $today->copy()->addDays(2))
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooks',
            'totalBookStock',
            'totalMembers',
            'totalBorrowedBooks',
            'overdueCount',
            'thisMonthBorrowings',
            'borrowTrendLabels',
            'borrowTrendData',
            'categoryLabels',
            'categoryData',
            'popularBooks',
            'urgentBorrowings'
        ));
    }
}