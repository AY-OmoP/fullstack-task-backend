<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TeacherController extends BaseController
{
    public function index()
    {
        $teacherModel = new TeacherModel();
        $rows = $teacherModel
            ->select('teachers.id, auth_user.email, auth_user.first_name, auth_user.last_name, teachers.university_name, teachers.gender, teachers.year_joined, teachers.created_at')
            ->join('auth_user', 'auth_user.id = teachers.user_id')
            ->findAll();

        return $this->response->setJSON($rows);
    }

    // Single POST API to insert into auth_user + teachers with FK
    public function create()
    {
        $rules = [
            'email'          => 'required|valid_email|is_unique[auth_user.email]',
            'first_name'     => 'required|min_length[2]',
            'last_name'      => 'required|min_length[2]',
            'password'       => 'required|min_length[6]',
            'university_name'=> 'required|min_length[2]',
            'gender'         => 'required|in_list[male,female,other]',
            'year_joined'    => 'required|integer|greater_than_equal_to[1950]|less_than_equal_to[' . date('Y') . ']',
        ];
        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)
                ->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $userModel = new UserModel();
            $userId = $userModel->insert([
                'email'      => $this->request->getPost('email'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name'  => $this->request->getPost('last_name'),
                'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ], true);

            $teacherModel = new TeacherModel();
            $teacherModel->insert([
                'user_id'        => $userId,
                'university_name'=> $this->request->getPost('university_name'),
                'gender'         => $this->request->getPost('gender'),
                'year_joined'    => (int) $this->request->getPost('year_joined'),
            ], true);

            $db->transComplete();
            return $this->response->setJSON(['message' => 'Teacher created', 'user_id' => $userId]);
        } catch (DatabaseException $e) {
            $db->transRollback();
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Failed', 'error' => $e->getMessage()]);
        }
    }
}
