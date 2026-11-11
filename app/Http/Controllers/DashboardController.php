<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowingDetail;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalBookStock = Book::sum('stock');
        $totalMembers = Member::count();
        $totalBorrowedBooks = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        return view('dashboard.index', compact('totalBooks', 'totalBookStock',
         'totalMembers', 'totalBorrowedBooks'));
    }
    
}
