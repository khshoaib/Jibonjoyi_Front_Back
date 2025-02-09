<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'footer';

    // Allow mass assignment for both 'text' and 'status' fields
    protected $fillable = ['text', 'status'];
}
