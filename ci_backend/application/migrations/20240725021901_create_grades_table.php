<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_grades_table extends CI_Migration
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
            ]
        ];
    }
    public function down()
    {
    }
}
