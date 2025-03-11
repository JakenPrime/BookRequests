<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYears extends Model
{
    use HasFactory;
    protected $table = 'school_years';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'year',
    ];

    function classes(): HasMany {
        return $this->hasMany(Classes::class, 'school_year');
    }
}