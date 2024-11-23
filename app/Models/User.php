<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\FuncCall;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'username',
    //     'email',
    //     'password',
    // ];
    protected $guarded =['id'];
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts() : HasMany {
       return $this->hasMany(Post::class, 'author_id');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function commentsreplies() : HasMany
    {
        return $this->hasMany(CommentReply::class, 'user_id');
    }

    public function link(){
        return $this->hasMany(Link::class, 'user_id');
    }

    public function todo(){
        return $this->hasMany(Todo::class, 'user_id');
    }
}
