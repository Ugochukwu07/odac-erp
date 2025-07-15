<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_admin_activity_log extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'admin_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'admin_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'admin_mobile' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'activity_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'activity_description' => array(
                'type' => 'TEXT',
            ),
            'target_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'target_table' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pt_admin_activity_log');
    }

    public function down() {
        $this->dbforge->drop_table('pt_admin_activity_log');
    }
} 