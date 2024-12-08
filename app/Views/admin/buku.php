<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table Perpustakaan</li>
    </ol>
    <a href="/buku/create" class="btn btn-primary mb-3">Tambah Buku</a>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penerbit</th>
                        <th>Pengarang</th>
                        <th>Jumlah Halaman</th>
                        <th>ISBN</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Judul</th>
                        <th>Penerbit</th>
                        <th>Pengarang</th>
                        <th>Jumlah Halaman</th>
                        <th>ISBN</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($buku as $item): ?>
                        <tr>
                            <td><?= $item['JudulBuku'] ?></td>
                            <td><?= $item['Penerbit'] ?></td>
                            <td><?= $item['Pengarang'] ?></td>
                            <td><?= $item['JumlahHalaman'] ?></td>
                            <td><?= $item['ISBN'] ?></td>
                            <td><?= $item['TahunTerbit'] ?></td>
                            <td><?= $item['Quantity'] ?></td>
                            <td>
                                <a href="/buku/edit/<?= $item['ISBN'] ?>" class="btn btn-warning">Edit</a>
                                <form action="/buku/<?= $item['ISBN'] ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>