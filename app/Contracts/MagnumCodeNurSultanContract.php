<?php


namespace App\Contracts;


class MagnumCodeNurSultanContract
{
    const TABLE                 =   'magnum_codes_nursultan';

    const PRODUCT_ID            =   'product_id';
    const PARENT_ID             =   'parent_id';
    const NAME                  =   'name';

    const FILLABLE              =   [
        self::PRODUCT_ID,
        self::PARENT_ID,
        self::NAME
    ];
}
