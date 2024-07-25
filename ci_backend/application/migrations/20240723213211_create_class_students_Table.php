<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_class_students_table extends CI_Migration
{


    public function up()
    {
        $fields = [
            'class_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'student_username' => [
                'type' => "VARCHAR",
                'constraint' => 20,
            ],

        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(['student_username', 'class_id'], true);

        $this->dbforge->create_table('class_students');
    }

    public function down()
    {
        $this->dbforge->drop_table('class_students');
    }
}
