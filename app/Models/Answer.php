<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create($validated)
 * @method static paginate(mixed $per_page)
 */
class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Field requirements to create a quiz answer
     *
     * @var string[]
     */
    protected $fillable = [
        'answer_text',
        'is_correct',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected bool $softDelete = true;
}
