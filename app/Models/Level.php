<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(mixed $per_page)
 * @method static create($validated)
 * @method static where(bool $param)
 * @method static getPdo()
 * @method static latest(string $string)
 */
class Level extends Model
{
    use HasFactory;

    /**
     * Field requirements to create an AQF level
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    /**
     * This method establishes a One-to-Many relationship between levels and quizzes
     * (ie: An AQF level has many quizzes)
     *
     * @return HasMany
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
