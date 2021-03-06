<?php
require_once 'sst_class.php';
require_once 'company_dd.php';
class company_sst extends sst
{
    function __construct()
    {
        $this->fields        = company_dd::load_dictionary();
        $this->relations     = company_dd::load_relationships();
        $this->subclasses    = company_dd::load_subclass_info();
        $this->table_name    = company_dd::$table_name;
        $this->readable_name = company_dd::$readable_name;
        parent::__construct();
    }
}
