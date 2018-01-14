<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function isAdmin() {
        if ($this->role === 'admin') {
            return true;
        }
        return false;
    }

    public function generateApiToken() {
        $this->api_token = \str_random(60);
        $this->save();
        return $this->api_token;
    }

    public function destroyApiToken() {
        $this->api_token = null;
        $this->save(); //check if saves null
        return true;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function publish(Post $post) {
        return $this->posts()->save($post);
    }

    public function writeComment(Comment $cmt) {
        return $this->comments()->save($cmt);
    }
}
