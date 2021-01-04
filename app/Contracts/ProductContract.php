<?php


namespace App\Contracts;


class ProductContract
{

    const ID                        =   'id';

    const PRICE                     =   'price';
    const E_CLUB                    =   'eClub';
    const ALTERNATIVE_PRICE         =   'alternativePrice';
    const DIFFERENCE                =   'difference';

    const TABLE                     =   'products';
    const USER_ID                   =   'user_id';
    const SKU                       =   'sku';
    const NOMENCLATURE              =   'nomenclature';
    const NAME                      =   'name';
    const PROVIDER                  =   'provider';
    const PRICE_ALMATY              =   'price_almaty';
    const PRICE_NURSULTAN           =   'price_nursultan';
    const PRICE_AKTOBE              =   'price_aktobe';
    const PRICE_USKAMAN             =   'price_uskaman';
    const PRICE_SHYMKENT            =   'price_shymkent';
    const PRICE_KARAGANDA           =   'price_karaganda';
    const PRICE_KYZYLORDA           =   'price_kyzylorda';
    const PRICE_URALSK              =   'price_uralsk';
    const PRICE_TALDYKORGAN         =   'price_taldykorgan';
    const PRICE_AKTAU               =   'price_aktau';
    const PRICE_TARAZ               =   'price_taraz';
    const PRICE_SEMEY               =   'price_semey';
    const PRICE_TURKESTAN           =   'price_turkestan';
    const PRICE_ALMATY_ECLUB        =   'price_almaty_eclub';
    const PRICE_NURSULTAN_ECLUB     =   'price_nursultan_eclub';
    const PRICE_AKTOBE_ECLUB        =   'price_aktobe_eclub';
    const PRICE_USKAMAN_ECLUB       =   'price_uskaman_eclub';
    const PRICE_SHYMKENT_ECLUB      =   'price_shymkent_eclub';
    const PRICE_KARAGANDA_ECLUB     =   'price_karaganda_eclub';
    const PRICE_KYZYLORDA_ECLUB     =   'price_kyzylorda_eclub';
    const PRICE_URALSK_ECLUB        =   'price_uralsk_eclub';
    const PRICE_TALDYKORGAN_ECLUB   =   'price_taldykorgan_eclub';
    const PRICE_AKTAU_ECLUB         =   'price_aktau_eclub';
    const PRICE_TARAZ_ECLUB         =   'price_taraz_eclub';
    const PRICE_SEMEY_ECLUB         =   'price_semey_eclub';
    const PRICE_TURKESTAN_ECLUB     =   'price_turkestan_eclub';

    const FILLABLE  =   [
        self::USER_ID,
        self::SKU,
        self::NOMENCLATURE,
        self::NAME,
        self::PROVIDER,
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
        self::PRICE_TURKESTAN,
        self::PRICE_ALMATY_ECLUB,
        self::PRICE_NURSULTAN_ECLUB,
        self::PRICE_AKTOBE_ECLUB,
        self::PRICE_USKAMAN_ECLUB,
        self::PRICE_SHYMKENT_ECLUB,
        self::PRICE_KARAGANDA_ECLUB,
        self::PRICE_KYZYLORDA_ECLUB,
        self::PRICE_URALSK_ECLUB,
        self::PRICE_TALDYKORGAN_ECLUB,
        self::PRICE_AKTAU_ECLUB,
        self::PRICE_TARAZ_ECLUB,
        self::PRICE_SEMEY_ECLUB,
        self::PRICE_TURKESTAN_ECLUB
    ];
}
