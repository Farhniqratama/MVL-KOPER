<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{   
    use HasFactory;

    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table   = "review";
}
