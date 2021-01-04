<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ProductContract;
use App\Contracts\MagnumProductContract;
use App\Contracts\DetskiiMirProductContract;

class Products extends Model
{
    use HasFactory;
    protected $fillable =   ProductContract::FILLABLE;

    public function magnum()
    {
        return $this->hasOne('App\Models\MagnumProducts',MagnumProductContract::PRODUCT_ID,ProductContract::ID);
    }

    public function detskiimir()
    {
        return $this->hasOne('App\Models\DetskiiMirProducts',DetskiiMirProductContract::PRODUCT_ID,ProductContract::ID);
    }

}
