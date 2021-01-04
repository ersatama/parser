<?php


namespace App\Contracts;


class DetskiiMirContract
{
    const TABLE                 =   'detskii_mirs';

    const FUNC                  =   'detskiimir';

    const PARENT_ID             =   'parent_id';
    const URL                   =   'url';
    const NAME                  =   'name';

    const FILLABLE              =   [
        self::PARENT_ID,
        self::URL,
        self::NAME
    ];
}
