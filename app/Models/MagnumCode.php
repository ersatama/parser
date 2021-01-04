<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\MagnumCodeContract;

class MagnumCode extends Model
{
    use HasFactory;

    protected $fillable =   MagnumCodeContract::FILLABLE;
}
