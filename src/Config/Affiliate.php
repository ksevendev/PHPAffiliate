<?php
    namespace Affiliate\Config;

    use CodeIgniter\Config\BaseConfig;

    class Affiliate extends BaseConfig
    {

        public string $apiURL = "affilia.test";

        public string $apikey = "6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKC";

        public bool $forceSecureRequests = false;
        
        public int $timeOut = 0;

        public string $version = "1.0.0";

    }