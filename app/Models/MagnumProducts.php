<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\MagnumProductContract;

class MagnumProducts extends Model
{
    use HasFactory;
    protected $fillable =   MagnumProductContract::FILLABLE;
}
