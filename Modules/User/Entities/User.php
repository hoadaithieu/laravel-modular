<?php

namespace Modules\User\Entities;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

//class User extends Authenticatable
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use Filterable;
    use Sortable;

    protected $primaryKey = 'id';

    protected $filterFields = [
        'name',
        'email',
    ];

    protected $sortFields = [
        'name',
        'email',
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
    ];

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Set default attributes value
     */

    protected $attributes = [
    ];

    //const CREATED_AT = 'CREATED_DATETIME';
    //const UPDATED_AT = 'MODIFIED_DATETIME';

    protected $table = 'users';

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new ();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
public function companies(): BelongsToMany
{
//return $this->belongsToMany(Company::class)->using(UserCompany::class);
return $this->belongsToMany(Company::class, 'user_company_mapping', 'USER_ID', 'COMPANY_ID');
}
 */
}
