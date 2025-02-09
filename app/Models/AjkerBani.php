<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjkerBani extends Model
{
    use HasFactory;

    protected $table = 'ajker_bani';

    protected $fillable = ['bani_writer', 'bani', 'status'];

    public $timestamps = true;
}
