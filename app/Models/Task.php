<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Allow mass-assignment for these fields
     protected $fillable = ['title', 'description', 'user_id', 'due_at', 'priority'];
     protected $casts = [
        'due_at' => 'datetime',
    ];

}
