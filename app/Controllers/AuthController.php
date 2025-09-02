<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    public function register()
    {
        $rules = [
            'email'      => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'password'   => 'required|min_length[6]',
        ];
        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)
                ->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $data = [
            'email'      => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        $userModel = new UserModel();
        $id = $userModel->insert($data, true);

        return $this->response->setJSON(['message' => 'Registered', 'id' => $id]);
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if (! $user || ! password_verify($password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON(['message' => 'Invalid credentials']);
        }

        $payload = [
            'iss'  => base_url(),
            'iat'  => time(),
            'nbf'  => time(),
            'exp'  => time() + 60 * 60 * 4, // 4 hours
            'data' => [
                'id'         => $user['id'],
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
            ]
        ];
        $secret = config('App')->jwtSecret ?? env('app.jwtSecret');
        $token  = JWT::encode($payload, $secret, 'HS256');

        return $this->response->setJSON(['token' => $token]);
    }

    public function listUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->select('id, email, first_name, last_name, created_at')->findAll();
        return $this->response->setJSON($users);
    }
}
