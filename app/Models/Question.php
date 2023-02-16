<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(mixed $per_page)
 * @method static create($validated)
 * @method static wherein(string $string, array $list)
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Field requirements to create a PLUMS question
     *
     * @var string[]
     */
    protected $fillable = [
        'question_text',
        'answer_set',
        'points_value',
        'is_available',
    ];

    protected $guarded = [
        'written_by',
        'times_used',
        'times_answered_correctly',
        'times_answered_incorrectly',
        'answers',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = ['answer_set' => 'array'];

    public $timestamps = true;

    protected $softDelete = true;
}
