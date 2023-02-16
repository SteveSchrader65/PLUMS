<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(mixed $per_page)
 * @method static create($validated)
 * @method static getPdo()
 * @method static latest(string $string)
 */
class Field extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Field requirements to create a study-field
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $softDelete = true;

    /**
     * This method establishes a One-to-Many relationship between study-fields and skills
     * (ie: A study-field has many skills)
     *
     * @return HasMany
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'field_id');
    }

    /**
     * This method establishes a One-to-Many relationship between study-fields and quizzes
     * (ie: A study-field has many quizzes via the skills table)
     *
     * @return HasManyThrough
     */
    public function quizzes(): HasManyThrough
    {
        return $this->hasManyThrough(Quiz::class, Skill::class);
    }
}
