<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ModelBuku;
use App\Models\TransactionsModel;


class Cart extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to view your cart.');
        }

        $cartModel = new CartModel();
        $userId = session()->get('UserID');
        $cart = $cartModel->where('UserID', $userId)->findAll();
        $buku = new ModelBuku();
        foreach ($cart as &$item) {
            $book = $buku->find($item['ISBN']);
            $item['JudulBuku'] = $book['JudulBuku'];
        }

        $data = [
            'cart' => $cart
        ];

        return view('cart', $data);
    }

    public function addToCart()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to add items to the cart.');
        }

        $isbn = $this->request->getVar('isbn');

        // Fetch the book from the ModelBuku model
        $buku = new ModelBuku();
        $book = $buku->find($isbn);

        if ($book) {
            // Check if the book is in stock (quantity available)
            if ($book['Quantity'] > 0) {
                $cartModel = new CartModel();
                $userId = session()->get('UserID');

                // Check if the book is already in the cart
                $existingCartItem = $cartModel->where('UserID', $userId)->where('ISBN', $isbn)->first();

                if ($existingCartItem) {
                    // Check if the user is trying to add more than the available stock
                    if ($existingCartItem['Quantity'] < $book['Quantity']) {
                        // Update the quantity in the cart
                        $cartModel->update($existingCartItem['CartID'], [
                            'Quantity' => $existingCartItem['Quantity'] + 1
                        ]);
                    } else {
                        // Cannot add more than available stock
                        return redirect()->to('/')->with('msg', 'Cannot add more than available stock.');
                    }
                } else {
                    // Add the book to the cart if not already in the cart
                    $cartData = [
                        'UserID' => $userId,
                        'ISBN' => $isbn,
                        'Quantity' => 1,
                        'DateAdded' => date('Y-m-d H:i:s')
                    ];
                    $cartModel->insert($cartData);
                }

                return redirect()->to('/')->with('msg', 'Book added to cart successfully.');
            } else {
                // Book is out of stock
                return redirect()->to('/')->with('msg', 'Book is out of stock.');
            }
        }

        // Book not found
        return redirect()->to('/')->with('msg', 'Book not found.');
    }

    public function remove()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to remove items from the cart.');
        }

        $isbn = $this->request->getVar('isbn');

        $cartModel = new CartModel();
        $userId = session()->get('UserID');

        // Fetch the cart item
        $cartItem = $cartModel->where('UserID', $userId)->where('ISBN', $isbn)->first();

        if ($cartItem) {
            // Remove the item from the cart
            $cartModel->delete($cartItem['CartID']);

            return redirect()->to('/cart')->with('msg', 'Item removed from cart successfully.');
        }

        // Cart item not found
        return redirect()->to('/cart')->with('msg', 'Cart item not found.');
    }

    public function updateQuantity()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to update cart items.');
        }

        $isbn = $this->request->getVar('isbn');
        $quantity = $this->request->getVar('quantity');

        $cartModel = new CartModel();
        $userId = session()->get('UserID');

        // Fetch the cart item
        $cartItem = $cartModel->where('UserID', $userId)->where('ISBN', $isbn)->first();

        if ($cartItem) {
            $buku = new ModelBuku();
            $book = $buku->find($isbn);

            if ($quantity === 'increase') {
                // Check if the book is in stock and if the cart quantity is less than available stock
                if ($book['Quantity'] > $cartItem['Quantity']) {
                    // Increase the quantity in the cart
                    $cartModel->update($cartItem['CartID'], [
                        'Quantity' => $cartItem['Quantity'] + 1
                    ]);
                } else {
                    // Book is out of stock or cart has reached the stock limit
                    return redirect()->to('/cart')->with('msg', 'Cannot add more than available stock.');
                }
            } elseif ($quantity === 'decrease') {
                // Check if the quantity is already 1
                if ($cartItem['Quantity'] === 1) {
                    // Remove the item from the cart
                    $cartModel->delete($cartItem['CartID']);
                } else {
                    // Decrease the quantity in the cart
                    $cartModel->update($cartItem['CartID'], [
                        'Quantity' => $cartItem['Quantity'] - 1
                    ]);
                }
            }

            return redirect()->to('/cart')->with('msg', 'Cart updated successfully.');
        }

        // Cart item not found
        return redirect()->to('/cart')->with('msg', 'Cart item not found.');
    }

    public function checkout()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to checkout.');
        }

        $cartModel = new CartModel();
        $transactionModel = new TransactionsModel();
        $buku = new ModelBuku();

        $userId = session()->get('UserID');
        $cart = $cartModel->where('UserID', $userId)->findAll();

        if (!empty($cart)) {

            // Calculate total price and reduce stock
            foreach ($cart as $item) {
                $book = $buku->find($item['ISBN']);
                if ($book['Quantity'] < $item['Quantity']) {
                    return redirect()->to('/cart')->with('msg', "Insufficient stock for book: {$book['JudulBuku']}");
                }

                $buku->update($item['ISBN'], [
                    'Quantity' => $book['Quantity'] - $item['Quantity']
                ]);
            }

            // Record the transaction
            $transactionId = $transactionModel->insert([
                'UserID' => $userId,
                'Status' => 'Completed',
            ]);

            // Clear the cart
            $cartModel->where('UserID', $userId)->delete();

            // Redirect to checkout success page
            return view('checkout_success', [
                'transactionId' => $transactionId
            ]);
        }

        // Cart is empty
        return redirect()->to('/cart')->with('msg', 'Cart is empty.');
    }
}
