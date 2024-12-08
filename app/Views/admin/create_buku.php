<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <h1 class="mt-4">Tambah Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/buku">Data Buku</a></li>
        <li class="breadcrumb-item active">Tambah Buku</li>
    </ol>
    <form action="/buku/store" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="JudulBuku" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="JudulBuku" name="JudulBuku" required>
        </div>
        <div class="mb-3">
            <label for="Penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="Penerbit" name="Penerbit" required>
        </div>
        <div class="mb-3">
            <label for="Pengarang" class="form-label">Pengarang</label>
            <input type="text" class="form-control" id="Pengarang" name="Pengarang" required>
        </div>
        <div class="mb-3">
            <label for="JumlahHalaman" class="form-label">Jumlah Halaman</label>
            <input type="number" class="form-control" id="JumlahHalaman" name="JumlahHalaman" required>
        </div>
        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" required>
        </div>
        <div class="mb-3">
            <label for="TahunTerbit" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="TahunTerbit" name="TahunTerbit" required>
        </div>
        <div class="mb-3">
            <label for="Quantity" class="form-label">Stok</label>
            <input type="number" class="form-control" id="Quantity" name="Quantity" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/buku" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>