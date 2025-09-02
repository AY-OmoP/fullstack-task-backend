<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('auth_user')->insertBatch([
            [
                'email' => 'alice@example.com',
                'first_name' => 'Alice',
                'last_name' => 'Anders',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'bob@example.com',
                'first_name' => 'Bob',
                'last_name' => 'Baker',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        $this->db->table('teachers')->insertBatch([
            [
                'user_id' => 1,
                'university_name' => 'University of Benin',
                'gender' => 'male',
                'year_joined' => 2018,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'university_name' => 'Ahmadu Bello University',
                'gender' => 'female',
                'year_joined' => 2020,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
