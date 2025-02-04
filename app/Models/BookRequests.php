<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class BookRequests  extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'book_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'book_id',
        'order_id',
        'quantity',
        'ordered',
    ];
    
    function books(): BelongsTo {        
        return $this->belongsTo(Books::class, 'book_id');
    }
    
    function requests(): BelongsTo {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}