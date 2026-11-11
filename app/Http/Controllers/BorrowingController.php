<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'member', 'details.book'])->latest()->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)->orderBy('title')->get();
        return view('borrowings.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id'   => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'book_ids'    => 'required|array|min:1',
            'book_ids.*'  => 'exists:books,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $borrowDate = Carbon::parse($request->borrow_date);
                $dueDate = $borrowDate->copy()->addWeek(); // Otomatis 1 minggu dari tanggal pinjam

                $borrowing = Borrowing::create([
                    'user_id'     => Auth::id(),
                    'member_id'   => $request->member_id,
                    'borrow_date' => $borrowDate->format('Y-m-d'),
                    'due_date'    => $dueDate->format('Y-m-d'),
                    'status'      => 'borrowed',
                ]);

                foreach ($request->book_ids as $bookId) {
                    $book = Book::lockForUpdate()->findOrFail($bookId);

                    if ($book->stock < 1) {
                        throw new \Exception("Stok buku '{$book->title}' habis.");
                    }

                    BorrowingDetail::create([
                        'borrowing_id' => $borrowing->id,
                        'book_id'      => $book->id,
                        'quantity'     => 1,
                    ]);

                    $book->decrement('stock', 1);
                }
            });

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil dicatat dan stok buku telah dikurangi.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'member', 'details.book']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Transaksi peminjaman ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->update([
                'return_date' => Carbon::now()->format('Y-m-d'),
                'status'      => 'returned',
            ]);

            foreach ($borrowing->details as $detail) {
                $detail->book()->increment('stock', $detail->quantity);
            }
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan dan stok buku telah ditambahkan kembali.');
    }
}