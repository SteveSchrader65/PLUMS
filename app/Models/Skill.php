<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(mixed $per_page)
 * @method static create($validated)
 * @method static getPdo()
 * @method static latest(string $string)
 */
class Skill extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Field requirements to create a skill for a study-field
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'field_id',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $softDelete = true;

    /**
     * This method establishes a One-to-Many relationship between skills and study-fields
     * (ie: A skill belongs to one study-field)
     *
     * @return BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * This method establishes a One-to-Many relationship between skills and quizzes
     * (ie: A skill has many quizzes)
     *
     * @return HasMany
     */
    public function quizzes(): HasMany
    {
        return $this->HasMany(Quiz::class);
    }
}

