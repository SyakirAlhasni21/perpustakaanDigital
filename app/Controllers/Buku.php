<?php

namespace App\Controllers;

use App\Models\ModelBuku;

class Buku extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Please log in to access the home page.');
        }
        // Check role
        if (session()->get('Role') == 'Admin') {
            $bukuModel = new ModelBuku();
            $data = [
                'buku' => $bukuModel->findAll(),
            ];

            return view('admin/buku', $data);
        }
    }

    public function create()
    {
        return view('admin/create_buku');
    }

    public function store()
    {
        $bukuModel = new ModelBuku();

        // Define validation rules
        $validationRules = [
            'ISBN' => [
                'rules' => 'required|exact_length[13]|is_unique[buku.ISBN]',
                'errors' => [
                    'required' => 'ISBN is required.',
                    'exact_length' => 'ISBN must be exactly 13 characters long.',
                    'is_unique' => 'This ISBN already exists in the database.',
                ],
            ],
            'JudulBuku' => 'required',
            'Penerbit' => 'required',
            'Pengarang' => 'required',
            'JumlahHalaman' => 'required|integer',
            'TahunTerbit' => 'required|integer',
            'Quantity' => 'required|integer',
            'gambar' => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('uploads', $namaGambar);

        // Collect data
        $data = [
            'JudulBuku' => $this->request->getPost('JudulBuku'),
            'Penerbit' => $this->request->getPost('Penerbit'),
            'Pengarang' => $this->request->getPost('Pengarang'),
            'JumlahHalaman' => $this->request->getPost('JumlahHalaman'),
            'ISBN' => $this->request->getPost('ISBN'),
            'TahunTerbit' => $this->request->getPost('TahunTerbit'),
            'Quantity' => $this->request->getPost('Quantity'),
            'gambar' => $namaGambar,
        ];

        $bukuModel->insert($data);
        return redirect()->to('/buku')->with('msg', 'Buku berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $bukuModel = new ModelBuku();
        $data = [
            'buku' => $bukuModel->find($id),
        ];

        return view('admin/edit_buku', $data);
    }

    public function update($id)
    {
        $bukuModel = new ModelBuku();
        $existingBuku = $bukuModel->find($id);

        // Define validation rules
        $validationRules = [
            'ISBN' => [
                'rules' => "required|exact_length[13]|is_unique[buku.ISBN,ISBN,{$existingBuku['ISBN']}]",
                'errors' => [
                    'required' => 'ISBN is required.',
                    'exact_length' => 'ISBN must be exactly 13 characters long.',
                    'is_unique' => 'This ISBN already exists in the database.',
                ],
            ],
            'JudulBuku' => 'required',
            'Penerbit' => 'required',
            'Pengarang' => 'required',
            'JumlahHalaman' => 'required|integer',
            'TahunTerbit' => 'required|integer',
            'Quantity' => 'required|integer',
            'gambar' => 'if_exist|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads', $namaGambar);
        } else {
            $namaGambar = $this->request->getPost('gambar_lama');
        }

        // Collect data
        $data = [
            'JudulBuku' => $this->request->getPost('JudulBuku'),
            'Penerbit' => $this->request->getPost('Penerbit'),
            'Pengarang' => $this->request->getPost('Pengarang'),
            'JumlahHalaman' => $this->request->getPost('JumlahHalaman'),
            'ISBN' => $this->request->getPost('ISBN'),
            'TahunTerbit' => $this->request->getPost('TahunTerbit'),
            'Quantity' => $this->request->getPost('Quantity'),
            'gambar' => $namaGambar,
        ];

        $bukuModel->update($id, $data);
        return redirect()->to('/buku')->with('msg', 'Buku berhasil diupdate.');
    }


    public function delete($id)
    {
        $bukuModel = new ModelBuku();
        $buku = $bukuModel->find($id);

        // Delete the image file
        if ($buku['gambar']) {
            unlink('uploads/' . $buku['gambar']);
        }

        $bukuModel->delete($id);
        return redirect()->to('/buku')->with('msg', 'Buku berhasil dihapus.');
    }
}
