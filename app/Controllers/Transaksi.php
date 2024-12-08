<?php

namespace App\Controllers;

use App\Models\TransactionsModel;

class Transaksi extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to access the home page.');
        }
        // Check role
        if (session()->get('Role') == 'Admin') {
            $transaksiModel = new TransactionsModel();
            $data = [
                'transaksi' => $transaksiModel->findAll(),
            ];

            return view('admin/transaksi', $data);
        }
    }
}
