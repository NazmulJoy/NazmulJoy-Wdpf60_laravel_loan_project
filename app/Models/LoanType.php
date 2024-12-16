<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'description',
        'min_amount',
        'max_amount',
        'default_interest_rate',
    ];
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
