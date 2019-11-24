<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function transaction() {
    //     return $this->belongsTo(Transaction::class);
    // }

    public function lottery() {
        return $this->belongsTo(Lottery::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'my_invoice_id');
    }
}
