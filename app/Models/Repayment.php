<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'installment_number',
        'due_date',
        'amount',
        'status',
        'paid_at',
    ];
    protected static function booted()
    {
        static::updating(function ($repayment) {
            
            if ($repayment->isDirty('status') && $repayment->status == 'paid') {
                $repayment->paid_at = now(); 
            }
        });
    }
  
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

  
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
