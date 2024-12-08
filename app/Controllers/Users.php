<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function login()
    {
        $session = session();
        $model = new UsersModel();

        // Input validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$this->validate($validation->getRules())) {
            $session->setFlashdata('msg', 'Username and Password are required');
            return redirect()->to('/')->withInput();
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->where('Username', $username)->first();

        if ($data) {
            $pass = $data['Password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'UserID' => $data['UserID'],
                    'Username' => $data['Username'],
                    'FullName' => $data['FullName'],
                    'Email' => $data['Email'],
                    'Phone' => $data['Phone'],
                    'Role' => $data['Role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            }
        }

        // Generic error message
        $session->setFlashdata('msg', 'Invalid username or password');
        return redirect()->to('/');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function register()
    {
        return view('register');
    }

    public function save()
    {
        $session = session();
        $model = new UsersModel();

        // Input validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|is_unique[users.Username]',
            'fullname' => 'required',
            'email' => 'required|valid_email|is_unique[users.Email]',
            'phone' => 'required',
            'password' => 'required|min_length[8]',
            'special_code' => 'permit_empty'
        ]);

        if (!$this->validate($validation->getRules())) {
            $session->setFlashdata('errors', $validation->getErrors());
            return redirect()->to('/register')->withInput();
        }

        // Determine the role based on the special code
        $specialCode = $this->request->getVar('special_code');
        $role = ($specialCode === 'ADMIN123') ? 'Admin' : 'Member';

        $data = [
            'Username' => $this->request->getVar('username'),
            'FullName' => $this->request->getVar('fullname'),
            'Email' => $this->request->getVar('email'),
            'Phone' => $this->request->getVar('phone'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => $role // Set the role
        ];

        try {
            $model->save($data);
            $session->setFlashdata('msg', 'Registration successful! You can now log in.');
            return redirect()->to('/');
        } catch (\Exception $e) {
            $session->setFlashdata('msg', 'An error occurred while saving your data.');
            return redirect()->to('/register')->withInput();
        }
    }
}
