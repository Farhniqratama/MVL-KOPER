<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{   
    use HasFactory;

    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table   = "retur";
}
