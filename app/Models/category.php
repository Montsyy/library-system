<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    protected $fillabel = ['name'];
    public function books() : HasMany {
        return $this -> hasMany(Book::class);
    }
}
