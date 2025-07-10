<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_hooks {

    public function set_db_sql_mode()
    {
        $CI =& get_instance();
        if (isset($CI->db)) {
            $CI->db->query("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
        }
    }
} 