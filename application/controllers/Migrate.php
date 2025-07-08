<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load the migration library
        $this->load->library('migration');
    }

    public function index() {
        // Check if migrations are enabled
        if ($this->migration->migration_enabled === FALSE) {
            show_error('Migrations are not enabled.');
            return;
        }

        // Run migrations
        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migrations completed successfully!';
        }
    }

    public function reset() {
        // Reset to version 0
        if ($this->migration->version(0) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migrations reset successfully!';
        }
    }

    public function version($version = NULL) {
        if ($version === NULL) {
            echo 'Current migration version: ' . $this->migration->current();
            return;
        }

        if ($this->migration->version($version) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migration to version ' . $version . ' completed successfully!';
        }
    }
} 