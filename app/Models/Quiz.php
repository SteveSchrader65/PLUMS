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
 */
class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Field requirements to create a user attempt to complete a PLUMS quiz
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'question_set',
        'level_id',
        'field_id',
        'skill_id',
        'is_available',
    ];

    protected $guarded = [
        'prepared_by',
        'times_attempted',
        'fastest_time',
        'average_time',
        'questions',
    ];

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $casts = ['question_set' => 'array'];

    public $timestamps = true;

    protected $softDelete = true;

    /**
     * This method establishes a One-to-Many relationship between quizzes and specializations
     * (ie: A quiz belongs to one specialization)
     *
     * @return belongsTo
     */
    public function skill(): belongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * This method establishes a One-to-Many relationship between quizzes and AQF levels
     * (ie: A quiz belongs to one AQF Level)
     *
     * @return belongsTo
     */
    public function level(): belongsTo
    {
        return $this->belongsTo(Level::class);
    }


//    /**
//     * --- !!! EXPERIMENTAL AND UNTESTED !!! ---
//     * This method establishes a One-to-Many relationship between quizzes and answers
//     * (ie: A quiz has many answers via the questions table)
//     *
//     * @return HasManyThrough
//     */
//    public function answers(): HasManyThrough
//    {
//        CODE TO RETRIEVE EACH ANSWER
//        return $this->hasManyThrough(Answer::class, Question::class);
//    }


    /**
     * This method establishes a One-to-Many relationship between quizzes and quiz attempts
     * (ie: A quiz can have many quiz attempts)
     *
     * @return HasMany
     */
    public function attempts(): HasMany
    {
        return $this->HasMany(Attempt::class);
    }
}
