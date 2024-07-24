<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_class_table extends CI_Migration
{

    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 20,
                'auto_increment' => TRUE

            ],
            'class_students_id' => [
                'type' => "INT",
                'constraint' => 11,
            ],
            "teacher_username" => [
                "type" => "VARCHAR",
                'constraint' => 20
            ],
            "course_id" => [
                "type" => "VARCHAR",
                "constraint" => 11
            ]

        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('class');
    }

    public function down()
    {
        $this->dbforge->drop_table('class');
    }
}
