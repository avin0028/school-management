<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_course_table extends CI_Migration
{


    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 20,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => "VARCHAR",
                'constraint' => 20,
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('course');
    }

    public function down()
    {
        $this->dbforge->drop_table('course');
    }
}
