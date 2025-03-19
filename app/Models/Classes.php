<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'class_id',
        'course_id',
        'school_year',
        'teacher_id',
        'students',
        'max',
    ];

    function teacher(): BelongsTo {        
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
    function course(): BelongsTo {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    function orders(): HasMany {
        return $this->hasMany(Orders::class, 'class_id');
    }

}