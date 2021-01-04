<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\DetskiiMirContract;
use App\Contracts\ProductContract;
use App\Repositories\Products\ProductsRepositoryEloquent;
use function Symfony\Component\String\s;

class ProductController extends Controller
{

    protected $urlPage          =   'https://api.europharma.kz/app/products?p=';
    protected $token            =   'Authorization: Bearer x9wEDGkY6vuxYeFR0dl4-L75E3C0_C_L';
    protected $json             =   'Content-Type: application/json';

    protected $city             =   ProductContract::PRICE_ALMATY;
    protected $eClub            =   ProductContract::PRICE_ALMATY_ECLUB;
    protected $shop             =   DetskiiMirContract::FUNC;

    protected $products;

    public function __construct(Request $request)
    {
        $this->products =   new ProductsRepositoryEloquent();
        if ($request->ajax()) {
            parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $queries);
            $this->setCity($queries['city']);
        } else {
            $this->setCity($request->input('city'));
        }
    }

    public function setCity($request):void
    {
        $city   =   trim($request);
        if ($city === ProductContract::PRICE_ALMATY) {
            $this->city     =   ProductContract::PRICE_ALMATY;
            $this->eClub    =   ProductContract::PRICE_ALMATY_ECLUB;
        } elseif ($city === ProductContract::PRICE_NURSULTAN) {
            $this->city     =   ProductContract::PRICE_NURSULTAN;
            $this->eClub    =   ProductContract::PRICE_NURSULTAN_ECLUB;
        } elseif ($city === ProductContract::PRICE_AKTAU) {
            $this->city     =   ProductContract::PRICE_AKTAU;
            $this->eClub    =   ProductContract::PRICE_AKTAU_ECLUB;
        } elseif ($city === ProductContract::PRICE_USKAMAN) {
            $this->city     =   ProductContract::PRICE_USKAMAN;
            $this->eClub    =   ProductContract::PRICE_USKAMAN_ECLUB;
        } elseif ($city === ProductContract::PRICE_SEMEY) {
            $this->city     =   ProductContract::PRICE_SEMEY;
            $this->eClub    =   ProductContract::PRICE_SEMEY_ECLUB;
        } elseif ($city === ProductContract::PRICE_KARAGANDA) {
            $this->city     =   ProductContract::PRICE_KARAGANDA;
            $this->eClub    =   ProductContract::PRICE_KARAGANDA_ECLUB;
        } elseif ($city === ProductContract::PRICE_KYZYLORDA) {
            $this->city     =   ProductContract::PRICE_KYZYLORDA;
            $this->eClub    =   ProductContract::PRICE_KYZYLORDA_ECLUB;
        } elseif ($city === ProductContract::PRICE_TALDYKORGAN) {
            $this->city     =   ProductContract::PRICE_TALDYKORGAN;
            $this->eClub    =   ProductContract::PRICE_TALDYKORGAN_ECLUB;
        } elseif ($city === ProductContract::PRICE_TURKESTAN) {
            $this->city     =   ProductContract::PRICE_TURKESTAN;
            $this->eClub    =   ProductContract::PRICE_TURKESTAN_ECLUB;
        } elseif ($city === ProductContract::PRICE_SHYMKENT) {
            $this->city     =   ProductContract::PRICE_SHYMKENT;
            $this->eClub    =   ProductContract::PRICE_SHYMKENT_ECLUB;
        } elseif ($city === ProductContract::PRICE_TARAZ) {
            $this->city     =   ProductContract::PRICE_TARAZ;
            $this->eClub    =   ProductContract::PRICE_TARAZ_ECLUB;
        }
    }

    public function shopSearch($value)
    {
        $city           =   $this->city;
        $shopProducts   =   $this->products->shopSearch($value,$city);
        return view('shop-tr',compact('shopProducts','city'));
    }

    public function dashboard()
    {
        $products   =   $this->products->list($this->city,$this->eClub);
        $filter     =   $this->products->filter($products);
        $name       =   $filter[ProductContract::NAME];
        $provider   =   $filter[ProductContract::PROVIDER];
        return view('index',compact(ProductContract::TABLE,ProductContract::NAME,ProductContract::PROVIDER));
    }

    public function export()
    {
        return $this->products->exports($this->city,$this->eClub);
    }

    public function updateShop($target,$selected)
    {
        $product    =   $this->products->updateShop($target,$selected,$this->shop,$this->city,$this->eClub);
        return view('tr',$product);
    }

    public function store(Request $request)
    {
        $product    =   $this->products->store($request->all(), $this->city, $this->eClub);
        return view('tr',$product);
    }

    public function update(Request $request)
    {
        $request    =   $request->all();
        $this->products->update($request);
        $product    =   $this->products->getById($request[ProductContract::ID], $this->city, $this->eClub, $this->shop);
        return view('tr',$product);
    }

    public function remove($id)
    {
        $this->products->resetShopByProductId($id);
        $product    =   $this->products->getById($id,$this->city,$this->eClub,$this->shop);
        return view('tr',$product);
    }

    public function resetShop()
    {
        $this->products->resetShop();
    }

    public function cronShopPrice($id)
    {
        $city   =   $this->products->getCityById($id);
        $this->products->cronShop($city);
    }

    public function stockUpdate()
    {
        $this->products->cron();
    }

    public function getById($id)
    {
        return $this->products->getById($id,$this->city,$this->eClub,$this->shop);
    }
}
