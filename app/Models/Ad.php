<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the pluralized model name
    protected $table = 'ad';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'vertical_ad1',
        'vertical_ad2',
        'horizontal_ad',
    ];

    // Disable timestamps if 'created_at' and 'updated_at' are not used
    public $timestamps = true;

    // Customize the default timestamp column names if needed
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // Disable updated_at if not needed
}
