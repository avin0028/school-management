<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_grade_table extends CI_Migration
{


    public function up()
    {
        $fields = [
            'student_username' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'class_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            "grade" => [
                "type" => "INT",
                "constraint" => 2
            ]
        ];
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(["class_id", "student_username"], TRUE);
        $this->dbforge->create_table('grade');
    }
    public function down()
    {
        $this->dbforge->drop_table('grade');
    }
}
