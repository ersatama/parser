<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\MagnumCodeNurSultanContract;

class MagnumCodeNurSultan extends Model
{
    use HasFactory;

    protected $fillable =   MagnumCodeNurSultanContract::FILLABLE;
}
