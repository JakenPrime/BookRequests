<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Books extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = 'books';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'isbn',
    ];

    function requests(): HasMany {
        return $this->hasmany(BookRequests::class, 'book_id');
    }
}