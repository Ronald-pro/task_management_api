<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protceted $fillable = [
        'title',
        'description',
        'priority',
        'due_date'
    ]
    
    protected $table = 'task';
}
