<?php

namespace Modules\User\Entities;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Entities\Company;
use Tymon\JWTAuth\Contracts\JWTSubject;

//class User extends Authenticatable
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use Filterable;
    use Sortable;

    protected $primaryKey = 'ID';

    protected $filterFields = [
        'EMAIL',
        'FIRST_NAME',
        'LAST_NAME', // relation
    ];

    protected $sortFields = [
        'FIRST_NAME',
        'LAST_NAME',
        'ID',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //'name',
        'EMAIL',
        'password',
        'FIRST_NAME',
        'LAST_NAME',
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
        'ROLE_TYPE' => 1,
        'CREATED_BY' => 1,
        'MODIFIED_BY' => 1,
    ];

    const CREATED_AT = 'CREATED_DATETIME';
    const UPDATED_AT = 'MODIFIED_DATETIME';

    protected $table = 'user';

    //protected $table = 'users';

    //protected static function newFactory()
    //{
    //    return \Modules\User\Database\factories\UserFactory::new ();
    //}

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

    public static function mappingFields($data, $exceptAr = ['password']): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            $newKey = in_array($key, $exceptAr) ? $key : strtoupper($key);
            $result[$newKey] = $value;
        }

        return $result;
    }

    public function companies(): BelongsToMany
    {
        //return $this->belongsToMany(Company::class)->using(UserCompany::class);
        return $this->belongsToMany(Company::class, 'user_company_mapping', 'USER_ID', 'COMPANY_ID');
    }
}
