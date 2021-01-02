<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bits extends Model
{
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
