<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function borrowings() {
        return $this->hasMany(Borrowing::class);
    }
}
