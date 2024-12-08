<?php

namespace App\Controllers;

use App\Models\ModelBuku;
use \App\Models\CartModel;
use \App\Models\TransactionsModel;
use \App\Models\UsersModel;

class Home extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to access the home page.');
        }
        // check role
        if (session()->get('Role') == 'Admin') {
            $bukuModel = new ModelBuku();
            $transactionModel = new TransactionsModel();
            $userModel = new UsersModel();

            $data = [
                'jumlahBuku' => $bukuModel->countAllResults(),
                'jumlahTransaksi' => $transactionModel->countAllResults(),
                'jumlahMember' => $userModel->where('Role', 'Member')->countAllResults(),
            ];

            return view('admin/dashboard', $data);
        }
        try {
            // Initialize the ModelBuku model
            $bukuModel = new ModelBuku();

            // Check if a search keyword is provided
            $keyword = $this->request->getPost('keyword');
            if ($keyword) {
                // Perform search query
                $data['buku'] = $bukuModel->like('JudulBuku', $keyword)
                    ->orLike('Pengarang', $keyword)
                    ->findAll();
            } else {
                // Fetch all books if no keyword is provided
                $data['buku'] = $bukuModel->findAll();
            }

            // Fetch total cart items (assuming you have a CartModel for cart data)
            $cartModel = new CartModel();
            $userId = session()->get('UserID');
            $data['totalCartItems'] = $cartModel->where('UserID', $userId)->countAllResults();

            // Pass the keyword back to the view for display
            $data['keyword'] = $keyword;

            // Load the home view with data
            return view('home', $data);
        } catch (\Exception $e) {
            // Handle database errors or unexpected exceptions
            return redirect()->to('/error')->with('msg', 'An error occurred: ' . $e->getMessage());
        }
    }
}
