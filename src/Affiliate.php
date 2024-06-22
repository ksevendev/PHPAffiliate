<?php

namespace Affiliate;

use Affiliate\Libraries\BaseLib;

class Affiliate extends BaseLib
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkConnection()
    {
        return $this->check_connection();
    }

    public function getProduct($id)
    {
        return $this->getProduct($id);
    }

}
