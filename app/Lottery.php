<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $guarded = [];

    // public function transactions() {
    //     return $this->hasMany(Transaction::class);
    // }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

}
