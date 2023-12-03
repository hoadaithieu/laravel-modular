<?php

namespace Modules\User\Entities;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Entities\User;

class Company extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use Filterable;
    use Sortable;

    protected $primaryKey = 'ID';

    protected $filterFields = [
        'name',
        'description',
        //'ADDRESS_1', // relation
    ];

    protected $sortFields = [
        'name',
        'description',
        //'ADDRESS_1', // relation
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        //'ADDRESS_1', // relation
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * Set default attributes value
     */

    protected $attributes = [
    ];

    protected $table = 'user_company';

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        //return $this->belongsToMany(User::class)->using(UserCompany::class);
        return $this->belongsToMany(User::class, 'user_company_mapping', 'COMPANY_ID', 'USER_ID');
    }
}
