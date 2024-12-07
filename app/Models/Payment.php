<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'amount', 'payment_type', 'payment_date', 'reference_number','details'];

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
