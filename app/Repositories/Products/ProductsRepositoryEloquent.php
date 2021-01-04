<?php


namespace App\Repositories\Products;


use App\Contracts\DetskiiMirContract;
use App\Contracts\DetskiiMirProductContract;
use App\Contracts\ProductContract;
use App\Exports\ProductExport;
use App\Models\DetskiiMir;
use App\Models\DetskiiMirProducts;
use App\Models\Products;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductsRepositoryEloquent implements ProductsRepositoryInterface
{

    public function resetShop():void
    {
        $shopProducts   =   DetskiiMirProducts::whereNotNull(DetskiiMirProductContract::PRODUCT_ID)->get()->toArray();
        foreach ($shopProducts as &$shopProduct)
        {
            $product    =   Products::where(ProductContract::SKU,$shopProduct[DetskiiMirProductContract::PRODUCT_ID])->first();
            if ($product) {
                $product    =   $product->toArray();
                DetskiiMirProducts::where(DetskiiMirProductContract::ID,$shopProduct[DetskiiMirProductContract::ID])->update([
                    ProductContract::SKU    =>  $product[ProductContract::ID]
                ]);
            }
        }
    }

    public function create(array $request):array
    {
        return Products::create([
            ProductContract::USER_ID                    =>  Auth::id(),

            ProductContract::NAME                       =>  $request[ProductContract::NAME],
            ProductContract::NOMENCLATURE               =>  $request[ProductContract::NOMENCLATURE],
            ProductContract::PROVIDER                   =>  $request[ProductContract::PROVIDER],
            ProductContract::SKU                        =>  $request[ProductContract::SKU],

            ProductContract::PRICE_ALMATY               =>  $request[ProductContract::PRICE_ALMATY],
            ProductContract::PRICE_NURSULTAN            =>  $request[ProductContract::PRICE_NURSULTAN],
            ProductContract::PRICE_AKTOBE               =>  $request[ProductContract::PRICE_AKTOBE],
            ProductContract::PRICE_USKAMAN              =>  $request[ProductContract::PRICE_USKAMAN],
            ProductContract::PRICE_TALDYKORGAN          =>  $request[ProductContract::PRICE_TALDYKORGAN],
            ProductContract::PRICE_AKTAU                =>  $request[ProductContract::PRICE_AKTAU],
            ProductContract::PRICE_TARAZ                =>  $request[ProductContract::PRICE_TARAZ],
            ProductContract::PRICE_SEMEY                =>  $request[ProductContract::PRICE_SEMEY],
            ProductContract::PRICE_TURKESTAN            =>  $request[ProductContract::PRICE_TURKESTAN],

            ProductContract::PRICE_ALMATY_ECLUB         =>  $request[ProductContract::PRICE_ALMATY_ECLUB],
            ProductContract::PRICE_NURSULTAN_ECLUB      =>  $request[ProductContract::PRICE_NURSULTAN_ECLUB],
            ProductContract::PRICE_AKTOBE_ECLUB         =>  $request[ProductContract::PRICE_AKTOBE_ECLUB],
            ProductContract::PRICE_USKAMAN_ECLUB        =>  $request[ProductContract::PRICE_USKAMAN_ECLUB],
            ProductContract::PRICE_TALDYKORGAN_ECLUB    =>  $request[ProductContract::PRICE_TALDYKORGAN_ECLUB],
            ProductContract::PRICE_AKTAU_ECLUB          =>  $request[ProductContract::PRICE_AKTAU_ECLUB],
            ProductContract::PRICE_TARAZ_ECLUB          =>  $request[ProductContract::PRICE_TARAZ_ECLUB],
            ProductContract::PRICE_SEMEY_ECLUB          =>  $request[ProductContract::PRICE_SEMEY_ECLUB],
            ProductContract::PRICE_TURKESTAN_ECLUB      =>  $request[ProductContract::PRICE_TURKESTAN_ECLUB],
        ])->toArray();
    }

    public function store(array $request,string $city, string $eClub):array
    {

        $product    =   $this->create($request);

        $product[ProductContract::DIFFERENCE]           =   '-';
        $product[ProductContract::ALTERNATIVE_PRICE]    =   '-';
        $product[ProductContract::PRICE]                =   '-';
        $product[ProductContract::E_CLUB]               =   '-';

        if ($product[$city]) {
            $product[ProductContract::PRICE]    =   $product[$city].' ₸';
        }

        if ($product[$eClub]) {
            $product[ProductContract::E_CLUB]   =   $product[$eClub].' ₸';
        }

        return $product;
    }

    public function update(array $request):void
    {
        Products::where(ProductContract::ID,$request[ProductContract::ID])->update([
            ProductContract::NAME                       =>  $request[ProductContract::NAME],
            ProductContract::NOMENCLATURE               =>  $request[ProductContract::NOMENCLATURE],
            ProductContract::PROVIDER                   =>  $request[ProductContract::PROVIDER],

            ProductContract::PRICE_ALMATY               =>  $request[ProductContract::PRICE_ALMATY],
            ProductContract::PRICE_NURSULTAN            =>  $request[ProductContract::PRICE_NURSULTAN],
            ProductContract::PRICE_AKTOBE               =>  $request[ProductContract::PRICE_AKTOBE],
            ProductContract::PRICE_USKAMAN              =>  $request[ProductContract::PRICE_USKAMAN],
            ProductContract::PRICE_TALDYKORGAN          =>  $request[ProductContract::PRICE_TALDYKORGAN],
            ProductContract::PRICE_AKTAU                =>  $request[ProductContract::PRICE_AKTAU],
            ProductContract::PRICE_TARAZ                =>  $request[ProductContract::PRICE_TARAZ],
            ProductContract::PRICE_SEMEY                =>  $request[ProductContract::PRICE_SEMEY],
            ProductContract::PRICE_TURKESTAN            =>  $request[ProductContract::PRICE_TURKESTAN],

            ProductContract::PRICE_ALMATY_ECLUB         =>  $request[ProductContract::PRICE_ALMATY_ECLUB],
            ProductContract::PRICE_NURSULTAN_ECLUB      =>  $request[ProductContract::PRICE_NURSULTAN_ECLUB],
            ProductContract::PRICE_AKTOBE_ECLUB         =>  $request[ProductContract::PRICE_AKTOBE_ECLUB],
            ProductContract::PRICE_USKAMAN_ECLUB        =>  $request[ProductContract::PRICE_USKAMAN_ECLUB],
            ProductContract::PRICE_TALDYKORGAN_ECLUB    =>  $request[ProductContract::PRICE_TALDYKORGAN_ECLUB],
            ProductContract::PRICE_AKTAU_ECLUB          =>  $request[ProductContract::PRICE_AKTAU_ECLUB],
            ProductContract::PRICE_TARAZ_ECLUB          =>  $request[ProductContract::PRICE_TARAZ_ECLUB],
            ProductContract::PRICE_SEMEY_ECLUB          =>  $request[ProductContract::PRICE_SEMEY_ECLUB],
            ProductContract::PRICE_TURKESTAN_ECLUB      =>  $request[ProductContract::PRICE_TURKESTAN_ECLUB],
        ]);
    }

    public function shopSearch(string $value, string $city):object
    {
        return DB::table(DetskiiMirProductContract::TABLE)
            ->select(DetskiiMirProductContract::NAME,
                DetskiiMirProductContract::CODE,
                DetskiiMirProductContract::ID,
                $city.' AS price')
            ->where(DetskiiMirProductContract::NAME,'like','%'.$value.'%')
            ->orWhere(DetskiiMirProductContract::CODE,$value)
            ->get();
    }

    public function exports(string $city, string $eClub)
    {
        $date   =   date('Y-m-d H:i:s');
        $title  =   join('_',[$city,$date]);

        return Excel::download(new ProductExport($city,$eClub),$title.'.xlsx');
    }

    public function filter(array $products):array
    {
        $name         =   [];
        $provider     =   [];

        foreach ($products as &$product)
        {
            $name[]     =   $product[ProductContract::NAME];
            $provider[] =   $product[ProductContract::PROVIDER];
        }

        return [
            ProductContract::NAME       =>  array_unique($name),
            ProductContract::PROVIDER   =>  array_unique($provider)
        ];
    }

    public function list(string $city, string $eClub):array
    {

        $products           =   Products::with(DetskiiMirContract::FUNC)
            ->orderBy(ProductContract::ID,'desc')
            ->get()->toArray();

        foreach ($products as &$product)
        {

            $product[ProductContract::ALTERNATIVE_PRICE]    =   '-';
            $product[ProductContract::DIFFERENCE]           =   '-';

            if ($product[DetskiiMirContract::FUNC]) {

                $product[ProductContract::ALTERNATIVE_PRICE]    =   intval(str_replace(' ','',$product[DetskiiMirContract::FUNC][$city]));

                if ($product[$city]) {

                    $product[ProductContract::DIFFERENCE]   =   ($product[$city] - $product[ProductContract::ALTERNATIVE_PRICE]).' ₸';

                }
                $product[ProductContract::ALTERNATIVE_PRICE]    .=  ' ₸';

            }

            $product[ProductContract::PRICE]    =   '-';
            if ($product[$city]) {
                $product[ProductContract::PRICE]    =   $product[$city].' ₸';
            }

            $product[ProductContract::E_CLUB]   =   '-';
            if ($product[$eClub]) {
                $product[ProductContract::E_CLUB]   =   $product[$eClub].' ₸';
            }

        }

        return $products;
    }

    public function resetShopByProductId(int $id):void
    {
        DetskiiMirProducts::where(DetskiiMirProductContract::PRODUCT_ID,$id)
            ->update([
                DetskiiMirProductContract::PRODUCT_ID => NULL
            ]);
    }

    public function updateShopById(int $id, int $shopId):void
    {
        DetskiiMirProducts::where(DetskiiMirProductContract::ID,$shopId)
            ->update([
                DetskiiMirProductContract::PRODUCT_ID => $id
            ]);
    }

    public function refreshShop(int $target, int $shopId, string $city, string $eClub, string $shop):array
    {
        $product    =   $this->getById($target,$city,$eClub,$shop);
        $this->resetShopByProductId($product[ProductContract::ID]);
        $this->updateShopById($product[ProductContract::ID],$shopId);
        return $product;
    }

    public function updateShop(int $target,int $selected,string $shop,string $city,string $eClub):array
    {
        $this->refreshShop($target, $selected, $city, $eClub, $shop);
        return $this->getById($target,$city,$eClub,$shop);
    }

    public function getById(int $id, string $city, string $eClub, string $shop):array
    {
        $product                                        =   Products::with($shop)->where(ProductContract::ID,$id)->first()->toArray();

        $product[ProductContract::DIFFERENCE]           =   '-';
        $product[ProductContract::PRICE]                =   '-';
        $product[ProductContract::E_CLUB]               =   '-';
        $product[ProductContract::ALTERNATIVE_PRICE]    =   '-';

        if ($product[$shop]) {
            $product[ProductContract::ALTERNATIVE_PRICE]    =   intval(str_replace(' ','',$product[$shop][$city]));
            if ($product[ProductContract::ALTERNATIVE_PRICE]) {
                $product[ProductContract::DIFFERENCE]   =   ($product[$city] - $product[ProductContract::ALTERNATIVE_PRICE]).' ₸';
                $product[ProductContract::ALTERNATIVE_PRICE]    .=  ' ₸';
            } else {
                $product[ProductContract::ALTERNATIVE_PRICE]    =   '-';
            }
        }

        if ($product[$city]) {
            $product[ProductContract::PRICE]    =   $product[$city].' ₸';
        }

        if ($product[$eClub]) {
            $product[ProductContract::E_CLUB]   =   $product[$eClub].' ₸';
        }

        return $product;
    }

    public function cityShortName(string $city):string
    {
        if ($city === DetskiiMirProductContract::PRICE_ALMATY) {
            return 'KZ-ALA';
        } elseif ($city === DetskiiMirProductContract::PRICE_NURSULTAN) {
            return 'KZ-AST';
        } elseif ($city === DetskiiMirProductContract::PRICE_AKTAU) {
            return 'KZ-MAN';
        } elseif ($city === DetskiiMirProductContract::PRICE_KYZYLORDA) {
            return 'KZ-KZY';
        } elseif ($city === DetskiiMirProductContract::PRICE_SEMEY) {
            return 'KZ-VOS';
        } elseif ($city === DetskiiMirProductContract::PRICE_KARAGANDA) {
            return 'KZ-KAR';
        } elseif ($city === DetskiiMirProductContract::PRICE_AKTOBE) {
            return 'KZ-AKT';
        } elseif ($city === DetskiiMirProductContract::PRICE_SHYMKENT) {
            return 'KZ-YUZ';
        } elseif ($city === DetskiiMirProductContract::PRICE_URALSK) {
            return 'KZ-ZAP';
        } elseif ($city === DetskiiMirProductContract::PRICE_TARAZ) {
            return 'KZ-ZHA';
        }
        return 'KZ-ALA';
        /*
        [7] => KZ-ZAP
        [8] => KZ-SEV
        [11] => KZ-KUS
        [12] => KZ-PAV
        [13] => KZ-AKM*/
    }

    public function getCityById(int $id):string
    {
        if ($id === 1) {
            return DetskiiMirProductContract::PRICE_ALMATY;
        } elseif ($id === 2) {
            return DetskiiMirProductContract::PRICE_NURSULTAN;
        } elseif ($id === 3) {
            return DetskiiMirProductContract::PRICE_AKTAU;
        } elseif ($id === 4) {
            return DetskiiMirProductContract::PRICE_KYZYLORDA;
        } elseif ($id === 5) {
            return DetskiiMirProductContract::PRICE_SEMEY;
        } elseif ($id === 6) {
            return DetskiiMirProductContract::PRICE_KARAGANDA;
        } elseif ($id === 7) {
            return DetskiiMirProductContract::PRICE_AKTOBE;
        } elseif ($id === 8) {
            return DetskiiMirProductContract::PRICE_SHYMKENT;
        } elseif ($id === 9) {
            return DetskiiMirProductContract::PRICE_URALSK;
        } elseif ($id === 10) {
            return DetskiiMirProductContract::PRICE_TARAZ;
        }
        return DetskiiMirProductContract::PRICE_ALMATY;
    }

    public function shopProductList():array
    {
        $shopProducts   =   DetskiiMir::all()->toArray();
        foreach ($shopProducts as &$shopProduct)
        {
            $url                =   explode('/',$shopProduct['url']);
            $size               =   sizeof($url)-2;
            $shopProduct['url'] =   $url[$size];
        }
        return $shopProducts;
    }

    public function curl(string $url,string $city,int &$offset,int &$limit)
    {
        $take       =   1000;

        if ($take > ($limit - $offset))
        {
            $take   =   $limit - $offset;
        }

        $code       =   $this->cityShortName($city);
        $url        =   'https://api.kz.detmir.com/v2/products?filter=categories[].alias:'.$url.';promo:false;withregion:'.$code.'&exclude=gauge&meta=*&limit='.$take.'&offset='.$offset.'&sort=popularity:desc';
        echo '<b>'.$url.'</b>';
        $ch         =   curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $res        =   curl_exec($ch);
        curl_close($ch);
        $res        =   json_decode($res,true);
        $out        =   [];
        if ($res)
        {
            if (array_key_exists('meta',$res))
            {
                $offset +=  $take;
                $limit  =   $res['meta']['length'];
                $out    =   $res['items'];
            }
        }
        return $out;
    }

    public function cronShop(string $city):void
    {
        $shopProducts   =   $this->shopProductList();
        foreach ($shopProducts as &$shopProduct)
        {
            $this->updateShopPrice($shopProduct[DetskiiMirContract::URL],$city);
        }
    }

    public function dom($res, &$pageLimit)
    {
        $dom    =   new DomDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' .$res);
        $finder =   new DomXPath($dom);
        $obj    =   $finder->query("//*[contains(@class, 'nf')]");

        if ($pageLimit === 1)
        {
            $length =   $finder->query("//*[contains(@class, 'h_5')]");
            foreach ($length as $it)
            {
                $pageLimit  =   $it->childNodes[ sizeof($it->childNodes)-1 ]->nodeValue;
                break;
            }
        }
        echo '<pre>';
        print_r($pageLimit);
        exit;
        return $obj;
    }

    public function updateShopPrice(string $url,string $city, int $offset = 0, int $limit = 200):void
    {
        if ($offset < $limit)
        {

            $res        =   $this->curl($url,$city,$offset,$limit);
            foreach ($res as &$item)
            {
                $shopProduct    =   DetskiiMirProducts::where(DetskiiMirProductContract::SELF_ID,$item['id'])->first();
                if ($shopProduct) {
                    echo 'updated - '.$item['id'].'<br>';
                    DetskiiMirProducts::where(DetskiiMirProductContract::SELF_ID,$item['id'])->update([
                        $city   =>  $item['price']['price']
                    ]);
                } else {
                    echo 'created - '.$item['id'].'<br>';
                    $productId  =   DetskiiMirProducts::create([
                        DetskiiMirProductContract::SELF_ID  =>  $item['id'],
                        DetskiiMirProductContract::CODE     =>  $item['code'],
                        DetskiiMirProductContract::NAME     =>  $item['title'],
                        $city                               =>  $item['price']['price']
                    ]);
                    $product    =   Products::where(ProductContract::SKU,$item['code'])->first();
                    if ($product) {
                        DetskiiMirProducts::where(DetskiiMirProductContract::ID,$productId->id)->update([
                            DetskiiMirProductContract::PRODUCT_ID   =>  $product->id
                        ]);
                    }
                }
            }
            $this->updateShopPrice($url,$city,$offset,$limit);
        }
    }

    protected $url  =   'https://api.europharma.kz/app/stocks?p=';

    public function productCurl(int $page = 1)
    {
        $ch    =   curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url.$page);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            $this->json,$this->token
        ]);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $body = json_decode(curl_exec($ch),TRUE);
        curl_close($ch);
        return $body;
    }

    public function cron(int $page = 1):void
    {
        $body   =   $this->productCurl($page);
        if ($body && array_key_exists('items',$body))
        {
            setlocale(LC_ALL,'C.UTF-8');
            foreach ($body['items'] as &$value)
            {
                Products::where([
                    [ProductContract::SKU,$value['product_id']],
                ])->update([
                    $this->cityName($value['city_id'])      =>  $value['price'],
                    $this->cityNameEClub($value['city_id']) =>  $value['sub_price']
                ]);
            }
            if ($page < $body['pageCount'])
            {
                $this->cron(++$page);
            }
        }
    }

    public function cityNameEClub(int $cityId):string
    {
        if ($cityId === 1) {
            return ProductContract::PRICE_ALMATY_ECLUB;
        } elseif ($cityId === 2) {
            return ProductContract::PRICE_NURSULTAN_ECLUB;
        } elseif ($cityId === 3) {
            return ProductContract::PRICE_AKTOBE_ECLUB;
        } elseif ($cityId === 4) {
            return ProductContract::PRICE_USKAMAN_ECLUB;
        } elseif ($cityId === 5) {
            return ProductContract::PRICE_SHYMKENT_ECLUB;
        } elseif ($cityId === 6) {
            return ProductContract::PRICE_KARAGANDA_ECLUB;
        } elseif ($cityId === 7) {
            return ProductContract::PRICE_KYZYLORDA_ECLUB;
        } elseif ($cityId === 8) {
            return ProductContract::PRICE_URALSK_ECLUB;
        } elseif ($cityId === 9) {
            return ProductContract::PRICE_TALDYKORGAN_ECLUB;
        } elseif ($cityId === 10) {
            return ProductContract::PRICE_AKTAU_ECLUB;
        } elseif ($cityId === 11) {
            return ProductContract::PRICE_TARAZ_ECLUB;
        } elseif ($cityId === 12) {
            return ProductContract::PRICE_SEMEY_ECLUB;
        }
        return ProductContract::PRICE_TURKESTAN_ECLUB;
    }

    public function cityName(int $cityId):string
    {
        if ($cityId === 1) {
            return ProductContract::PRICE_ALMATY;
        } elseif ($cityId === 2) {
            return ProductContract::PRICE_NURSULTAN;
        } elseif ($cityId === 3) {
            return ProductContract::PRICE_AKTOBE;
        } elseif ($cityId === 4) {
            return ProductContract::PRICE_USKAMAN;
        } elseif ($cityId === 5) {
            return ProductContract::PRICE_SHYMKENT;
        } elseif ($cityId === 6) {
            return ProductContract::PRICE_KARAGANDA;
        } elseif ($cityId === 7) {
            return ProductContract::PRICE_KYZYLORDA;
        } elseif ($cityId === 8) {
            return ProductContract::PRICE_URALSK;
        } elseif ($cityId === 9) {
            return ProductContract::PRICE_TALDYKORGAN;
        } elseif ($cityId === 10) {
            return ProductContract::PRICE_AKTAU;
        } elseif ($cityId === 11) {
            return ProductContract::PRICE_TARAZ;
        } elseif ($cityId === 12) {
            return ProductContract::PRICE_SEMEY;
        }
        return ProductContract::PRICE_TURKESTAN;
    }

}
