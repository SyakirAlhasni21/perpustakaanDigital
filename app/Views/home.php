<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="ml-auto">
        <a href="/cart" class="btn btn-primary">
            <i class="bi bi-cart-fill"></i> Keranjang <span class="badge badge-light"><?= htmlspecialchars($totalCartItems); ?></span>
        </a>
        <form action="/logout" method="get" class="d-inline">
            <button type="submit" name="logout" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Daftar Buku</h1>

    <!-- Search form -->
    <form action="" method="post" class="form-cari mb-4">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control"
                placeholder="Masukkan keyword pencarian..."
                value="<?= htmlspecialchars($keyword ?? '') ?>" autocomplete="off">
            <div class="input-group-append">
                <button type="submit" name="cari" class="btn btn-primary">Cari!</button>
            </div>
        </div>
    </form>

    <!-- Book list -->
    <div class="row justify-content-center">
        <?php foreach ($buku as $row) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= base_url('img/' . ($row['gambar'] ? $row['gambar'] : 'nophoto.jpg')) ?>" class="card-img-top" alt="Gambar Buku">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row["JudulBuku"]; ?></h5>
                        <p class="card-text">
                            <strong>ISBN:</strong> <?= $row["ISBN"]; ?><br>
                            <strong>Pengarang:</strong> <?= $row["Pengarang"]; ?><br>
                            <strong>Penerbit:</strong> <?= $row["Penerbit"]; ?><br>
                            <strong>Tahun:</strong> <?= $row["TahunTerbit"]; ?><br>
                            <strong>Halaman:</strong> <?= $row["JumlahHalaman"]; ?> <br>
                            <strong>Quantity Available:</strong> <?= $row["Quantity"]; ?>

                        </p>
                        <form method="post" action="/add-to-cart">
                            <input type="hidden" name="isbn" value="<?= $row["ISBN"]; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">
                                <i class="bi bi-cart-fill"></i> Add to Cart
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>