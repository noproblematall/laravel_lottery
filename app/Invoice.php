<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function invoice_payment()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'my_invoice_id');
    }

    public function invoice_pending_payment()
    {
        return $this->hasMany(InvoicePendingPayment::class, 'invoice_id', 'my_invoice_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'invoice_id', 'my_invoice_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
