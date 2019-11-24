<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePendingPayment extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'my_invoice_id');
    }
}
