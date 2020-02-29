<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class authors extends Model
{
    protected $fillable = ['name', 'suname'];

    public function books(){
        return $this->belongsToMany('App\Models\books', 'books_authors');
    }
}
