<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'email', 'phone', 'dob', 'address', 'class_id', 'admission_date'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
