<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'title', 'description', 'priority', 'user_id', 'is_done',
    ];
}
