<?php

namespace Modules\Post\Entities;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Database\factories\PostFactory;
use Modules\Post\Entities\Comment;

class Post extends Model
{
    use HasFactory;
    use Filterable, Sortable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'title',
        'content',
        'user_id',
    ];

    protected $sortFields = [
        'id',
        'content',
    ];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new ();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
