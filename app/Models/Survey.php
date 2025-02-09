<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'survey';

    // Define mass-assignable fields
    protected $fillable = [
        'question',
        'opt1',
        'opt2',
        'opt3',
        'opt4',
        'opt1_count',
        'opt2_count',
        'opt3_count',
        'opt4_count',
    ];

    public $timestamps = true;  // Enable timestamps if 'created_at' and 'updated_at' exist
}
