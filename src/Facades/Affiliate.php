<?php

namespace KSeven\Affiliate;

use Illuminate\Support\Facades\Facade;

/**
 * Class Factory.
 *
 * @method static \KSeven\Affiliate   checkConnection()
 * @method static \KSeven\Affiliate   getProduct($id)
 */
class Affiliate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Affiliate';
    }
}
