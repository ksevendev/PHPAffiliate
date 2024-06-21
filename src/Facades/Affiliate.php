<?php

namespace KSeven\PHPAffiliate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Factory.
 *
 * @method static \KSeven\PHPAffiliate   checkConnection()
 * @method static \KSeven\PHPAffiliate   getProduct($id)
 */
class Affiliate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Affiliate';
    }
}
