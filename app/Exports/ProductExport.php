<?php

namespace App\Exports;

use App\Contracts\DetskiiMirProductContract;
use App\Contracts\ProductContract;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
     * @param $city
     * @param $eClub
     */
    public $city;
    public $eClub;
    public $title;

    public function __construct($city, $eClub)
    {
        $this->city     =   $city;
        $this->eClub    =   $eClub;
        $this->title    =   $this->cityTitle($city);
    }

    public function cityTitle($city)
    {
        $title  =   '';
        if ($city === ProductContract::PRICE_ALMATY) {
            $title  =   'Алматы';
        } elseif ($city === ProductContract::PRICE_AKTOBE) {
            $title  =   'Актобе';
        } elseif ($city === ProductContract::PRICE_SHYMKENT) {
            $title  =   'Шымкент';
        } elseif ($city === ProductContract::PRICE_URALSK) {
            $title  =   'Уральск';
        } elseif ($city === ProductContract::PRICE_KARAGANDA) {
            $title  =   'Караганда';
        } elseif ($city === ProductContract::PRICE_SEMEY) {
            $title  =   'Семей';
        } elseif ($city === ProductContract::PRICE_TALDYKORGAN) {
            $title  =   'Талдыкорган';
        } elseif ($city === ProductContract::PRICE_KYZYLORDA) {
            $title  =   'Кызыл Орда';
        } elseif ($city === ProductContract::PRICE_NURSULTAN) {
            $title  =   'Нур-Султан';
        } elseif ($city === ProductContract::PRICE_USKAMAN) {
            $title  =   'Усть-Каменогорск';
        } elseif ($city === ProductContract::PRICE_AKTAU) {
            $title  =   'Актау';
        } elseif ($city === ProductContract::PRICE_TURKESTAN) {
            $title  =   'Туркестан';
        } elseif ($city === ProductContract::PRICE_TARAZ) {
            $title  =   'Тараз';
        }
        return $title;
    }

    public function headings(): array
    {
        return [
            'Код',
            'Производитель',
            'Номенклатура',
            'Поставщик',
            'Цена в '.$this->title.' (Europharma)',
            'Цена в '.$this->title.' eClub (Europharma)',
            'Цена в '.$this->title.' (Детский мир)',
        ];
    }

    public function collection()
    {
        return DB::table(ProductContract::TABLE)
            ->select(
                ProductContract::TABLE.'.'.ProductContract::SKU,
                ProductContract::TABLE.'.'.ProductContract::NAME,
                ProductContract::TABLE.'.'.ProductContract::NOMENCLATURE,
                ProductContract::TABLE.'.'.ProductContract::PROVIDER,
                ProductContract::TABLE.'.'.$this->city,
                ProductContract::TABLE.'.'.$this->eClub,
                DetskiiMirProductContract::TABLE.'.'.$this->city.' as DetskiMir',
            )
            ->leftJoin(
                DetskiiMirProductContract::TABLE,
                ProductContract::TABLE.'.'.ProductContract::SKU,
                '=',
                DetskiiMirProductContract::TABLE.'.'.DetskiiMirProductContract::PRODUCT_ID
            )
            ->get();
    }
}
