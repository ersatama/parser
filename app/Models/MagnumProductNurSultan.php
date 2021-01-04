<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\MagnumProductNursultanContract;

class MagnumProductNurSultan extends Model
{
    use HasFactory;

    protected $fillable =   MagnumProductNursultanContract::FILLABLE;
}
