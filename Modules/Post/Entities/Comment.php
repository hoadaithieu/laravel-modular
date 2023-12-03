<?php

namespace Modules\Post\Entities;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Database\factories\CommentFactory;
use Modules\Post\Entities\Post;

class Comment extends Model
{
    use HasFactory;
    use Filterable, Sortable;

    protected $filterFields = [
        'id',
        'content',
        'post_id',
        'user_id',
    ];

    protected $sortFields = [
        'id',
        'content',
    ];

    protected $table = 'post_comments';

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = ['post_id', 'user_id', 'content'];

    protected static function newFactory(): CommentFactory
    {
        return CommentFactory::new ();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
