<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function lottery() {
        return $this->belongsTo(Lottery::class);
    }

    public function tickets() {
        return $this->belongsTo(Ticket::class);
    }
}
