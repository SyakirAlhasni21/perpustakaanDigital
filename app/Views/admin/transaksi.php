<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Riwayat Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>User ID</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Transaction ID</th>
                        <th>User ID</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($transaksi as $transaction): ?>
                        <tr>
                            <td><?= $transaction['TransactionID'] ?></td>
                            <td><?= $transaction['UserID'] ?></td>
                            <td><?= $transaction['TransactionDate'] ?></td>
                            <td><?= $transaction['Status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>