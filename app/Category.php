<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alias',
        'name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'category_id',
    ];

    public $timestamps = false;    

    // public function getRouteKeyName() {
    //     return 'name';
    // }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}