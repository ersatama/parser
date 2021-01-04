<?php


namespace App\Contracts;


class MagnumProductNursultanContract
{
    const TABLE             =   'magnum_product_nur_sultan';

    const PRODUCT_ID        =   'product_id';
    const MAGNUM_ID         =   'magnum_id';
    const BRAND             =   'brand';
    const URL               =   'url';
    const NAME              =   'name';
    const PRICE_ALMATY      =   'price_almaty';
    const PRICE_NURSULTAN   =   'price_nursultan';
    const PRICE_AKTOBE      =   'price_aktobe';
    const PRICE_USKAMAN     =   'price_uskaman';
    const PRICE_SHYMKENT    =   'price_shymkent';
    const PRICE_KARAGANDA   =   'price_karaganda';
    const PRICE_KYZYLORDA   =   'price_kyzylorda';
    const PRICE_URALSK      =   'price_uralsk';
    const PRICE_TALDYKORGAN =   'price_taldykorgan';
    const PRICE_AKTAU       =   'price_aktau';
    const PRICE_TARAZ       =   'price_taraz';
    const PRICE_SEMEY       =   'price_semey';
    const PRICE_TURKESTAN   =   'price_turkestan';

    const FILLABLE          =   [
        self::PRODUCT_ID,
        self::MAGNUM_ID,
        self::BRAND,
        self::URL,
        self::NAME,
        self::PRICE_ALMATY,
        self::PRICE_NURSULTAN,
        self::PRICE_AKTOBE,
        self::PRICE_USKAMAN,
        self::PRICE_SHYMKENT,
        self::PRICE_KARAGANDA,
        self::PRICE_KYZYLORDA,
        self::PRICE_URALSK,
        self::PRICE_TALDYKORGAN,
        self::PRICE_AKTAU,
        self::PRICE_TARAZ,
        self::PRICE_SEMEY,
        self::PRICE_TURKESTAN
    ];
}
