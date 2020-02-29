<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class books extends Model
{
    protected $fillable = ['title', 'description','image'];

    public function authors(){
        return $this->belongsToMany('App\Models\authors', 'books_authors');
    }

    public function lendings(){
        return $this->belongsToMany('App\Models\lendings', 'books_lendings');
    }
}
