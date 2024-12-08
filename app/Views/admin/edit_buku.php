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
    <h1 class="mt-4">Edit Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/buku">Data Buku</a></li>
        <li class="breadcrumb-item active">Edit Buku</li>
    </ol>
    <form action="/buku/update/<?= $buku['ISBN'] ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label for="JudulBuku" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="JudulBuku" name="JudulBuku" value="<?= $buku['JudulBuku'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="Penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="Penerbit" name="Penerbit" value="<?= $buku['Penerbit'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="Pengarang" class="form-label">Pengarang</label>
            <input type="text" class="form-control" id="Pengarang" name="Pengarang" value="<?= $buku['Pengarang'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="JumlahHalaman" class="form-label">Jumlah Halaman</label>
            <input type="number" class="form-control" id="JumlahHalaman" name="JumlahHalaman" value="<?= $buku['JumlahHalaman'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" value="<?= $buku['ISBN'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="TahunTerbit" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="TahunTerbit" name="TahunTerbit" value="<?= $buku['TahunTerbit'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="Quantity" class="form-label">Stok</label>
            <input type="number" class="form-control" id="Quantity" name="Quantity" value="<?= $buku['Quantity'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar Baru</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            <small>Gambar saat ini:</small><br>
            <img src="/uploads/<?= $buku['gambar'] ?>" alt="Gambar Buku" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/buku" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>