<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'repayment_id',
        'user_id',
        'amount',
        'method',
        'status',
        'transaction_id'
    ];

   
    public function repayment()
    {
        return $this->belongsTo(Repayment::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
