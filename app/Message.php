<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $fillable = ['from','to','message','is_read'];
    public function from()
    {
        return $this->belongsTo('User', 'from');
    }

    public function to()
    {
        return $this->belongsToMany('User');
    }
    
}
