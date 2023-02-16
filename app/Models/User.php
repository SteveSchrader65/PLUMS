<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * @method static create($validated)
 * @method static where(string $string, mixed $email)
 * @method static paginate(mixed $per_page)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Field requirements to create a PLUMS user
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    protected $guarded = [
        'profile',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'profile' => 'object',
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * This method establishes a One-to-One relationship between users and profiles
     * (ie: A user has a profile)
     *
     * @return hasOne
     */
    public function profile(): hasOne
    {
        return $this->hasOne(UserProfile::class,'id','id');
    }

    /**
     * This method establishes a Many-to-One relationship between Users and Countries
     * (ie: Many users belong to a Country)
     *
     * @return belongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'code_3');
    }

    /**
     * This method establishes a One-to-Many relationship between users and quiz attempts
     * (ie: A user has many quiz attempts)
     *
     * @return hasMany
     */
    public function attempts(): hasMany
    {
        return $this->hasMany(Attempt::class);
    }
}
