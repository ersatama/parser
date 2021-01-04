<?php


namespace App\Contracts;


class UserContract
{
    const TABLE                     =   'users';
    const NAME                      =   'name';
    const EMAIL                     =   'email';
    const EMAIL_VERIFIED_AT         =   'email_verified_at';
    const PASSWORD                  =   'password';
    const CURRENT_TEAM_ID           =   'current_team_id';
    const PROFILE_PHOTO_PATH        =   'profile_photo_path';
    const REMEMBER_TOKEN            =   'remember_token';
    const TWO_FACTOR_RECOVERY_CODES =   'two_factor_recovery_codes';
    const TWO_FACTOR_SECRET         =   'two_factor_secret';
    const PROFILE_PHOTO_URL         =   'profile_photo_url';

    const FILLABLE                  =   [
        self::NAME,
        self::EMAIL,
        self::PASSWORD
    ];

    const HIDDEN                    =   [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
        self::TWO_FACTOR_RECOVERY_CODES,
        self::TWO_FACTOR_SECRET
    ];

}
