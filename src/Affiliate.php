<?php

namespace KSeven\Affiliate;


use KSeven\Affiliate\System\BaseLib;

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
