<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_class_table extends CI_Migration
{

    public function up()
    {
        $fields = [
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 20,

            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],

            'nickname' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],

            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 3
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('username', TRUE);
        $this->dbforge->create_table('class');
    }

    public function down()
    {
        $this->dbforge->drop_table('class');
    }
}
