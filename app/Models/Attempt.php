<?php
// NOTE: AN UNCOMPLETED QUIZ CAN BE CONTINUED BY MAKING A COPY OF THE
// ORIGINAL ATTEMPT INTO A NEW ATTEMPT

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

/**
 * @method static create(Request $request)
 */
class Attempt extends Model
{
    use HasFactory;

    /**
     * Field requirements to store a quiz attempt
     *
     * @var string[]
     */
    protected $guarded = [
        'quiz_id',
        'user_id',
        'answers_submitted',
        'score',
        'attempt_start',
        'attempt_end',
    ];

    protected $casts = [
        'answers_given' => 'array'
    ];

    public $timestamps = true;

    /**
     * This method establishes a Many-to-One relationship between quiz attempts and users
     * (ie: Many quiz attempts belong to one user)
     *
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This method establishes a One-to-One relationship between quiz attempts and quizzes
     * (ie: A quiz attempt has one quiz)
     *
     * @return hasOne
     */
    public function quiz(): hasOne
    {
        return $this->hasOne(Quiz::class);
    }
}
