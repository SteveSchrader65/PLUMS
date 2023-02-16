<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create($profile)
 */
class UserProfile extends Model
{
    use HasFactory;

    /**
     * Field requirements to create a PLUMS user profile
     *
     * @var string[]
     */
    protected $fillable = [
        'given_name',
        'family_name',
        'city',
        'country',
    ];

    protected $guarded = [
        'id',
    ];

    // Default values for field attributes
    protected $attributes = [
        'country' => 'AUS',
    ];

    public $timestamps = true;

    protected $dates = ['updated_at'];

    protected $hidden = ['id'];

//    /**
//     * This method establishes a One-to-One relationship between profiles and users
//     * (ie: A profile belongs to a user)
//     *
//     * @return belongsTo
//     */
//    public function user(): belongsTo
//    {
//        return $this->belongsTo(User::class,'id','id');
//    }
}
