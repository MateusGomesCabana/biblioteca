<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lendings extends Model
{
    protected $fillable = ['date_start', 'date_end','date_finish','user_id'];

    /**
     * Get the post that owns the comment.
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    
    public function books(){
        return $this->belongsToMany('App\Models\books', 'books_lendings');
    }
}
