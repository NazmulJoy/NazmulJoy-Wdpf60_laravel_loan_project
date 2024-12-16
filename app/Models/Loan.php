<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_type_id',
        'amount',
        'interest_rate',
        'duration',
        'status',
    ];

   // In the Loan model
protected static function booted()
{
    static::updating(function ($loan) {
        if ($loan->isDirty('status') && $loan->status == 'approved') {
            $loan->approved_at = now();
        }
    });
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    
    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }
}
