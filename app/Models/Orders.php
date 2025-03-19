<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Orders extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'orders';
    /**
     * @var int
     */
    const OPEN = 0;
    /**
     * @var int
     */
    const PENDING = 1;

    /**
     * @var int
     */
    const COMPLETED = 2;

    /**
     * @var int
     */
    const CANCELED = 3;

    /**
     * @var int
     */
    const ARCHIVED = 3;

    public function getStatus() {
        switch($this->status) {
            case 0:
                return "Open";
                break;
            case 1:
                return "Pending";
                break;
            case 2:
                return "Completed";
                break;
            case 3:
                return "Canceled";
                break;
            case 4:
                return "Archived";
                break;
            default:
                return "status error";
        }
    }   

    protected $fillable = [
        'user_id',
        'class_id',
    ];

    function bookRequests(): HasMany {
        return $this->hasMany(BookRequests::class, 'order_id');
    }

    function teacher(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    function class(): BelongsTo {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}