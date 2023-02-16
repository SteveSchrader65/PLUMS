<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(mixed $validated)
 * @method static count()
 * @property mixed $id
 */
class Country extends Model
{
    use HasFactory;

    /**
     * Requirements to create a Country
     *
     * @var string[]
     */
    protected $guarded = [
        'id',
        'name',
        'code_2',
        'code_3',
    ];

    public $timestamps = true;

    /**
     * This method establishes a Many-to-One relationship between Users and Countries
     * (ie: A Country has many Users)
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserProfile::class, 'country', 'code_3');
    }
}
