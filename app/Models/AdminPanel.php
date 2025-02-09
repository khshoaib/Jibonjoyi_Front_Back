<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPanel extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'admin_panel';

    // Specify the fields that are mass assignable
    protected $fillable = ['Role', 'Username', 'Email', 'Password'];
}
