<?php

namespace KSeven\PHPAffiliate;

use KSeven\PHPAffiliate\System\BaseLib;

class Affiliate extends BaseLib
{

    public function __construct()
    {}

    public function checkConnection()
    {
        return $this->check_connection();
    }

    public function getProduct($id)
    {
        return $this->getProduct($id);
    }

}
