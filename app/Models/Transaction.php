<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['total_amount', 'invoice_no', 'user_id'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
