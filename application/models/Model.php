<?php

defined("BASEPATH") or exit("No Direct Access Allowed!");

class Model extends CI_Model {
    protected $table;

    public function __construct() {
        parent::__construct();
    }

    public function create(array $data): self {
        $this->db->insert($this->table, $data);
        return $this;
    }
}