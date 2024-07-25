<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_schedule_table extends CI_Migration
{

    public function up()
    {
        $fields = [
            'class_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'weekname' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],

        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(["class_id", "weekname"], TRUE);
        $this->dbforge->create_table('schedule');
    }
    public function down()
    {
        $this->dbforge->drop_table('schedule');
    }
}
